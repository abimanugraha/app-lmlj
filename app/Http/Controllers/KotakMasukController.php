<?php

namespace App\Http\Controllers;

use App\Models\Analisa;
use Illuminate\Http\Request;
use App\Models\Masalah;
use App\Models\Jawaban;

class KotakMasukController extends Controller
{
    public function index()
    {
        auth()->user()->unit->masalah = $this->getKotakMasuk();
        $collection = Masalah::where('unit_id', auth()->user()->unit->id)
            ->where('status', 0)
            ->get();

        $data = [
            'title' => 'Kotak Masuk LMLJ',
            'slug'  => 'kotak-masuk-lmlj',
            'masalah' => $collection,
            'number' => 1
        ];

        // dd(auth()->user()->unit->id);
        // dd($collection);
        return view('lmlj.kotak-masuk', $data);
    }

    public function jawab(Masalah $masalah)
    {
        auth()->user()->unit->masalah = $this->getKotakMasuk();
        $data = [
            'title' => 'Lembar Jawaban LMLJ',
            'slug'  => 'kotak-masuk-lmlj',
            'masalah' => $masalah,
            'media_masalah' => $masalah->media,
            'detail_masalah' => $masalah->detailmasalah,
            'jawaban' => $masalah->jawaban,
            'number' =>  1
        ];

        return view('lmlj.lembar-jawaban', $data);
    }

    public function store(Request $request)
    {

        $data = $request->all();
        $data['masalah_id'] = Masalah::where('nolmlj', $request->nolmlj)->first()->id;
        $data['urgensi'] = $this->getUrgensiByTarget($request->target);
        $data['penerima_id'] = auth()->user()->id;
        $data['status'] = 0;
        // dd($this->getUrgensiByTarget($request->target));
        // dd($data);
        $validated = $this->validate($request, [
            'target' => 'required',
        ]);
        if ($validated) {
            $jawaban_id = Jawaban::orderBy('id', 'DESC')->first()->id + 1;
            foreach ($request->analisa as $item) {
                if ($item) {
                    $analisa['jawaban_id'] = $jawaban_id;
                    $analisa['analisa'] = $item;
                    Analisa::create($analisa);
                }
            }

            Jawaban::create($data);
        }
        return redirect(url('/detail/' . $request->nolmlj))->with('status', 'Jawaban berhasil dikirim');
    }
}
