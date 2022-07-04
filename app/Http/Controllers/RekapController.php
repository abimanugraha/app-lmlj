<?php

namespace App\Http\Controllers;

use App\Models\Analisa;
use Illuminate\Http\Request;
use App\Models\Masalah;
use App\Models\Jawaban;
use App\Models\Media;
use App\Models\Perbaikan;

class RekapController extends Controller
{
    public function index()
    {
        auth()->user()->unit->masalah = $this->getKotakMasuk();
        $collection = Jawaban::where('penerima_id', auth()->user()->id)
            ->where('keputusan', null)
            ->get();
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
        auth()->user()->unit->masalah = $this->getKotakMasuk();
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

        return view('lmlj.lembar-rekap', $data);
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'media.*' => 'mimes:jpeg,png,mov,mp4,mkv,avi,jpg',
        ]);
        // dd($request->perbaikan);
        if ($validated) {
            if ($request->hasFile('media')) {
                $index = 1;
                foreach ($request->file('media') as $item) {
                    $id = sprintf("%02d", $index++);
                    $file_name = $item->getClientOriginalExtension();
                    $name = $request->nolmlj . '-J' . $request->jawaban_id . '-' . $id . '.' . $file_name;
                    $unit = explode("-", $name);
                    $item->move(public_path() . '/upload_media/jawaban/' . $unit[0], $name);
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
        // dd($perbaikan);

        $jawaban = Jawaban::find($request->jawaban_id);
        $masalah = $jawaban->masalah;
        if ($jawaban->status == 3) {
            $masalah->status = 2;
            $masalah->save();
        } else {
            $masalah->status = 4;
            $masalah->save();
            // dd($masalah);
        }
        $jawaban = Jawaban::find($request->jawaban_id);
        $jawaban->nilai_tambah = $request->nilai_tambah;
        $jawaban->keputusan = $request->keputusan;
        $jawaban->pic_id = auth()->user()->id;
        $jawaban->status = $request->status;
        // dd($jawaban);
        $jawaban->save();
        return redirect(url('/dashboard'))->with('status', 'Rekap progress berhasil disimpan.');
    }
}
