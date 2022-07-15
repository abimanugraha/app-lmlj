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
        // dd($request->request);

        $masalah = Masalah::where('nolmlj', $request->nolmlj)->first();
        $data = $request->all();
        $data['masalah_id'] = $masalah->id;
        $data['urgensi'] = $this->getUrgensiByTarget($request->target);
        $data['penerima_id'] = auth()->user()->id;
        if ($request->forward) {
            $masalah->status = 3;
            $data['status'] = 3;
        } else {
            $masalah->status = 2;
            $data['status'] = 2;
        }
        // dd($this->getUrgensiByTarget($request->target));
        // dd($data);
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
                $forward['masalah_id'] = $masalah->id;
                $forward['unit_id'] = $request->unit_tujuan_id;
                $forward['status'] = 3;
                Forward::create($forward);
            }
            Jawaban::create($data);
        }
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
        $masalah->save();
        return $masalah->nolmlj;
        // return redirect(url('kotak-masuk-lmlj'))->with('status', 'Berhasil dikonfirmasi! Lembar masalah terkirim');
        // $masalah->status = 1;
    }
    public function redirect($nolmlj)
    {
        return redirect(url('detail/' . $nolmlj))->with('status', 'Berhasil dikonfirmasi! Lembar masalah terkirim');
    }
    public function konfirmasitembusan(Tembusan $tembusan)
    {
        $tembusan->status = 1;
        $tembusan->save();
        // return redirect(url('kotak-masuk-lmlj'))->with('status', 'Berhasil dikonfirmasi! Lembar masalah terkirim');
        // $masalah->status = 1;
    }
}
