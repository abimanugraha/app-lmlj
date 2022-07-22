<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masalah;
use App\Models\Produk;
use Nette\Utils\Json;

class HistoryController extends Controller
{
    //
    public function getCollection()
    {
        $query = Masalah::query();
        $query->join('lmljs', 'masalahs.lmlj_id', '=', 'lmljs.id');
        $query->leftJoin('forwards', 'masalahs.id', '=', 'forwards.masalah_id');
        $query->leftJoin('tembusans', 'lmljs.id', '=', 'tembusans.lmlj_id');

        // Pengkondisian
        $query->where('masalahs.unit_tujuan_id', auth()->user()->unit->id);
        $query->orwhere('forwards.unit_id', auth()->user()->unit->id);
        $query->orwhere('lmljs.unit_pengaju_id', auth()->user()->unit->id);
        if (auth()->user()->role_id == 2) {
            $query->orwhere('tembusans.unit_id', auth()->user()->unit->id);
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
        foreach ($collection as $item) {
            $item->color = $this->getUrgensiColor($item->target);
            $item->text_status = $this->getStatusText($item->status);
            $item->color_status = $this->getStatusColor($item->status);
        }
        return $collection;
    }

    public function index()
    {
        $collection = $this->getCollection();
        // dd($collection);
        $data = [
            'title' => 'History LMLJ',
            'slug'  => 'history',
            'masalah' => $collection,
            'kotak_masuk' => $this->getKotakMasuk(),
            'produk'    => Produk::all(),
            'number' => 1
        ];

        // dd(auth()->user()->unit->id);
        // dd($collection);
        return view('lmlj.history-lmlj', $data);
    }

    public function getHistoryLmlj(Request $request)
    {
        $collection = $this->getCollection();

        $response = array(
            'status' => 'success',
            'awal' => $request->tanggal_awal,
            'akhir' => $request->tanggal_akhir,
            'unit_id' => $request->unit_id,
        );
        return response()->json($collection);
    }
}
