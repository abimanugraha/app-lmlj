<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masalah;

class HistoryController extends Controller
{
    //

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
            'title' => 'History LMLJ',
            'slug'  => 'history',
            'masalah' => $collection,
            'kotak_masuk' => $this->getKotakMasuk(),
            'number' => 1
        ];

        // dd(auth()->user()->unit->id);
        // dd($collection);
        return view('lmlj.history-lmlj', $data);
    }
}
