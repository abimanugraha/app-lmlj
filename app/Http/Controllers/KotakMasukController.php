<?php

namespace App\Http\Controllers;

use App\Models\Analisa;
use App\Models\Forward;
use Illuminate\Http\Request;
use App\Models\Masalah;
use App\Models\Jawaban;
use App\Models\Lmlj;
use App\Models\Unit;
use App\Models\Tembusan;
use Carbon\Carbon;

class KotakMasukController extends Controller
{
    public function index()
    {
        $query = Masalah::query();
        $query->join('lmljs', 'masalahs.lmlj_id', '=', 'lmljs.id');
        $query->leftJoin('forwards', 'masalahs.id', '=', 'forwards.masalah_id');
        $query->leftJoin('tembusans', 'lmljs.id', '=', 'tembusans.lmlj_id');

        // Pengkondisian
        $query->where([['masalahs.unit_tujuan_id', auth()->user()->unit->id], ['masalahs.status', 1], ['masalahs.status', '<', 4]]);
        $query->orwhere([['forwards.unit_id', auth()->user()->unit->id], ['forwards.status', 0]]);
        if (auth()->user()->role_id == 2) {
            $query->orwhere([['lmljs.unit_pengaju_id', auth()->user()->unit->id], ['masalahs.status', 0]]);
            $query->orwhere([['tembusans.unit_id', auth()->user()->unit->id], ['tembusans.status', 0]]);
        }

        $list_get = [
            'masalahs.*',
            'lmljs.id AS lmlj_id',
            'lmljs.produk_id',
            'lmljs.pengaju_id',
            'lmljs.spv_pengaju_id',
            'lmljs.unit_pengaju_id',
            'tembusans.unit_id AS unit_tembusan_id',
            'tembusans.status AS status_tembusan',
            'forwards.unit_id AS unit_forward_id',
            'forwards.status AS status_forward'
        ];


        $collection = $query->get($list_get)->unique('id');
        $data = [
            'title' => 'Kotak Masuk LMLJ',
            'slug'  => 'kotak-masuk-lmlj',
            'masalah' => $collection,
            'kotak_masuk' => $this->getKotakMasuk(),
            'number' => 1
        ];

        // dd(auth()->user()->unit->id);
        // dd($collection);
        return view('lmlj.kotak-masuk', $data);
    }

    public function jawab(Masalah $masalah)
    {

        $masalah->target = $this->getDefaultTarget($masalah->urgensi);
        $masalah->color_urgensi = $this->getUrgensiColor($masalah->target);
        $data = [
            'title' => 'Lembar Jawaban LMLJ',
            'slug'  => 'kotak-masuk-lmlj',
            'masalah' => $masalah,
            'kotak_masuk' => $this->getKotakMasuk(),
            'media_masalah' => $masalah->media,
            'detail_masalah' => $masalah->detailmasalah,
            'jawaban' => $masalah->jawaban,
            'number' =>  1,
            'unit'      => Unit::where('id', '!=', auth()->user()->unit->id)->where('id', '!=', $masalah->lmlj->pengaju->unit->id)->get()
        ];


        return view('lmlj.lembar-jawaban', $data);
    }

    public function store(Request $request)
    {
        $masalah = Masalah::where('nolmlj', $request->nolmlj)->first();

        if ($masalah->forward->where('unit_id', auth()->user()->unit->id)->count() == 1) {
            $forward = Forward::find($masalah->forward->where('unit_id', auth()->user()->unit->id)->first()->id);
            $forward->status = 1;
            $forward->save();
        }

        $data = $request->all();
        $data['masalah_id'] = $masalah->id;
        $data['urgensi'] = $this->getUrgensiByTarget($request->target);
        $data['penerima_id'] = auth()->user()->id;
        $data['unit_id'] = auth()->user()->unit->id;
        if ($request->forward) {
            $masalah->status = 3;
            $data['status'] = 3;
        } else {
            $masalah->status = 2;
            $data['status'] = 2;
        }

        $validated = $this->validate($request, [
            'target' => 'required',
        ]);
        if ($validated) {
            $masalah_id = Jawaban::first();
            if ($masalah_id) {
                $jawaban_id = Jawaban::orderBy('id', 'DESC')->first()->id + 1;
            } else {
                $jawaban_id = 1;
            }
            foreach ($request->analisa as $item) {
                if ($item) {
                    $analisa['jawaban_id'] = $jawaban_id;
                    $analisa['analisa'] = $item;
                    Analisa::create($analisa);
                }
            }
            if ($request->forward) {
                foreach ($request->forward_unit as $item) {
                    $data_forward['masalah_id'] = $masalah->id;
                    $data_forward['unit_id'] = $item;
                    $data_forward['status'] = 0;
                    Forward::create($data_forward);
                }
            }
            Jawaban::create($data);
        }

        // dd($masalah);        
        $masalah->save();
        return redirect(url('/detail/' . $request->nolmlj))->with('status', 'Jawaban berhasil dikirim');
    }

    public function konfirmasimasalah(Masalah $masalah)
    {
        $lmlj = Lmlj::find($masalah->lmlj->id);
        $lmlj->spv_pengaju_id = auth()->user()->id;
        $lmlj->status = 1;
        $lmlj->save();
        $masalah->status = 1;
        $masalah->keterangan = "Terkirim";
        $masalah->tanggal_acc = new Carbon();
        $masalah->save();
        return $masalah->nolmlj;
        // return redirect(url('kotak-masuk-lmlj'))->with('status', 'Berhasil dikonfirmasi! Lembar masalah terkirim');
        // $masalah->status = 1;
    }

    public function konfirmasijawaban(Jawaban $jawaban)
    {

        $forward = Forward::where('unit_id', $jawaban->unit_id)->first();
        $masalah = $jawaban->masalah;
        if ($forward) {
            $forward->status = 1;
            $forward->save();
        } else {
            $masalah->status = 4;
            $masalah->save();
        }
        $jawaban->status = 4;
        $jawaban->save();

        $masalah = $jawaban->masalah;
        $jawaban_awal = $masalah->jawaban->first();
        $jawaban_forward = $masalah->jawaban->whereNotIn('id', [$jawaban_awal->id]);
        if ($jawaban_awal->unit_id != $jawaban->unit_id) {
            $jawaban_awal->status = 2;
            $jawaban_forward = $masalah->jawaban->whereNotIn('id', [$jawaban_awal->id]);
            foreach ($jawaban_forward as $item) {
                if ($item->status != 4) {
                    $jawaban_awal->status = 3;
                    break;
                }
            }
            $jawaban_awal->save();
        }
        return $jawaban->masalah->nolmlj;
    }
    public function redirect($nolmlj)
    {
        return redirect(url('detail/' . $nolmlj))->with('status', 'Berhasil dikonfirmasi! Lembar masalah terkirim');
    }
    public function redirectjawaban($nolmlj)
    {
        return redirect(url('detail/' . $nolmlj))->with('status', 'Berhasil dikonfirmasi! Jawaban terkirim');
    }
    public function konfirmasitembusan(Tembusan $tembusan)
    {
        $tembusan->status = 1;
        $tembusan->save();
        // return redirect(url('kotak-masuk-lmlj'))->with('status', 'Berhasil dikonfirmasi! Lembar masalah terkirim');
        // $masalah->status = 1;
    }
}
