<?php

namespace App\Http\Controllers;

use App\Models\Analisa;
use Illuminate\Http\Request;
use App\Models\Masalah;
use App\Models\Jawaban;
use App\Models\Media;
use App\Models\Perbaikan;
use App\Models\Forward;
use App\Models\HistoryKomponen;
use App\Models\Komponen;

class RekapController extends Controller
{
    public function index()
    {
        $penerima_id = $this->getPenerimaId();
        $query = Jawaban::query();
        foreach ($penerima_id as $id) {
            $query->orWhere([['penerima_id', $id], ['status', '!=', 4]]);
        }
        $query->where('keputusan', null);
        $collection = $query->get();
        // $collection = Jawaban::where('penerima_id', auth()->user()->id)
        //     ->where('keputusan', null)
        //     ->get();
        // dd($collection);
        // foreach ($collection as $item) {
        //     $masalah[] = $item->masalah;
        // }
        $data = [
            'title' => 'Rekap Progress LMLJ',
            'slug'  => 'rekap-progress-lmlj',
            'jawaban' => $collection,
            'kotak_masuk' => $this->getKotakMasuk(),
            // 'masalah' => $masalah,
            'number' => 1
        ];

        // dd(auth()->user()->unit->id);
        // dd($collection);
        return view('lmlj.kotak-rekap', $data);
    }

    public function rekap(Masalah $masalah, $_id)
    {
        $masalah->target = $this->getDefaultTarget($masalah->urgensi);
        $masalah->color_urgensi = $this->getUrgensiColor($masalah->target);
        $data = [
            'title' => 'Rekap Progress LMLJ',
            'slug'  => 'rekap-progress-lmlj',
            'masalah' => $masalah,
            'kotak_masuk' => $this->getKotakMasuk(),
            'media_masalah' => $masalah->media,
            'detail_masalah' => $masalah->detailmasalah,
            'jawaban_id' => $_id,
            'number' =>  1
        ];
        // dd($masalah->lmlj);

        return view('lmlj.lembar-rekap', $data);
    }

    public function store(Request $request)
    {
        // dd($request->request);
        if ($request->checktambahkomponen) {
            $data_komponen = [
                'produk_id' => $request->produk_id,
                'nama' => $request->nama,
                'nomor' => $request->nomor,
                'status' => 1
            ];
            Komponen::create($data_komponen);
            $komponen_id = Komponen::orderBy('id', 'DESC')->first()->id;
            $data_history_komponen = [
                'komponen_lama' => $request->komponen_id,
                'komponen_baru' => $komponen_id,
                'status' => 1
            ];
            HistoryKomponen::create($data_history_komponen);
            $komponen_lama = Komponen::find($request->komponen_id)->first();
            $komponen_lama->status = 0;
            $komponen_lama->save();
            // dd($komponen_lama);
        }

        $validated = $this->validate($request, [
            'media.*' => 'mimes:jpeg,png,mov,mp4,mkv,avi,jpg',
        ]);
        if ($validated) {
            if ($request->hasFile('media')) {
                $index = 1;
                foreach ($request->file('media') as $item) {
                    $id = sprintf("%02d", $index++);
                    $file_name = $item->getClientOriginalExtension();
                    $name = $request->nolmlj . '-J' . $request->jawaban_id . '-' . $id . '.' . $file_name;
                    $unit = explode("-", $name);
                    $item->move(public_path() . '/upload_media/jawaban/' . strtolower($unit[0]), $name);
                    $media['jawaban_id'] = $request->jawaban_id;
                    $media['file'] = $name;
                    Media::create($media);
                }
            }
        }
        for ($i = 0; $i < count($request->perbaikan); $i++) {
            $perbaikan['jawaban_id'] = $request->jawaban_id;
            $perbaikan['perbaikan'] = $request->perbaikan[$i];
            $perbaikan['created_at'] = $request->tanggal[$i];
            Perbaikan::create($perbaikan);
        }

        $jawaban = Jawaban::find($request->jawaban_id);
        $jawaban->nilai_tambah = $request->nilai_tambah;
        $jawaban->keputusan = $request->keputusan;
        $jawaban->pic_id = auth()->user()->id;
        $jawaban->status = 0;
        if (auth()->user()->role_id == 2) {
            $jawaban->status = 4;
        }
        $jawaban->save();
        $masalah = $jawaban->masalah;
        if ($masalah->forward->count() > 1) {
            $masalah->status = 4;
            foreach ($masalah->jawaban as $item) {
                if ($item->status != 4) {
                    $masalah->status = 2;
                    break;
                }
            }
            $forward = Forward::where('unit_id', $jawaban->unit_id)->first();
            if ($forward) {
                $forward->status = 2;
                if (auth()->user()->role_id == 2) {
                    $forward->status = 1;
                }
                $forward->save();
            }
            $masalah->save();
            // dd($masalah);
        } else {
            if ($masalah->jawaban->count() > 1 && $masalah->jawaban->first()->status == 3) {
                $update_jawaban = Jawaban::find($masalah->jawaban->where('id', '!=', $jawaban->id)->sortDesc()->first()->id);
                $update_jawaban->status = 2;
                $update_jawaban->save();
                $masalah->status = 2;
                $masalah->save();
            } else {
                $masalah->status = 2;
                if (auth()->user()->role_id == 2) {
                    $jawaban->status = 4;
                    $masalah->status = 4;
                }
                $masalah->save();
            }
        }



        return redirect(url('/dashboard'))->with('status', 'Rekap progress berhasil disimpan.');
    }
}
