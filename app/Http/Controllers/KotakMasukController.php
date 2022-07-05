<?php

namespace App\Http\Controllers;

use App\Models\Analisa;
use App\Models\Forward;
use Illuminate\Http\Request;
use App\Models\Masalah;
use App\Models\Jawaban;
use App\Models\Unit;

class KotakMasukController extends Controller
{
    public function index()
    {
        $pengaju_id = $this->getPengajuId();
        // auth()->user()->unit->masalah = $this->getKotakMasuk();
        // $collection = Masalah::where([['unit_id', auth()->user()->unit->id], ['status', 1]])
        //     ->orwhere([['pengaju_id', $pengaju_id], ['status', 0]])
        //     ->get();
        // $pengaju_id = $this->getPengajuId();
        // auth()->user()->unit->masalah = $this->getKotakMasuk();
        $collection = Masalah::with(['pengaju', 'diketahui', 'unit', 'jawaban'])
            ->leftJoin('forwards', 'masalahs.id', '=', 'forwards.masalah_id')
            ->where([['masalahs.unit_id', auth()->user()->unit->id], ['masalahs.status', 1]])
            ->orwhere([['masalahs.pengaju_id', $pengaju_id], ['masalahs.status', 0]])
            ->orWhere([['forwards.unit_id', auth()->user()->unit->id], ['masalahs.status', 3]])
            ->get(['masalahs.*', 'forwards.unit_id AS unit_forwad_id']);

        // dd($collection);
        // $kotak_masuk = $this->getKotakMasuk();
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
            'unit'      => Unit::where('id', '!=', auth()->user()->unit->id)->where('id', '!=', $masalah->pengaju->unit->id)->get()
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
        $masalah->status = 1;
        $masalah->ygmengetahui_id = auth()->user()->id;
        $masalah->keterangan = "Terkirim";
        $masalah->save();
        // return redirect(url('kotak-masuk-lmlj'))->with('status', 'Berhasil dikonfirmasi! Lembar masalah terkirim');
        // $masalah->status = 1;
    }
    public function redirect()
    {
        return redirect(url('kotak-masuk-lmlj'))->with('status', 'Berhasil dikonfirmasi! Lembar masalah terkirim');
    }
    public function konfirmasitembusan(Forward $forward)
    {
        $forward->status = 6;
        $forward->save();
        // return redirect(url('kotak-masuk-lmlj'))->with('status', 'Berhasil dikonfirmasi! Lembar masalah terkirim');
        // $masalah->status = 1;
    }
}
