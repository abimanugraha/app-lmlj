<?php

namespace App\Http\Controllers;

use App\Models\Forward;
use App\Models\Masalah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $pengaju_id = $this->getPengajuId();
        $collection = Masalah::with(['pengaju', 'diketahui', 'unit', 'jawaban'])
            ->leftJoin('forwards', 'masalahs.id', '=', 'forwards.masalah_id')
            ->where('masalahs.unit_id', auth()->user()->unit->id)
            ->orWhere('masalahs.pengaju_id', $pengaju_id)
            ->orWhere('forwards.unit_id', auth()->user()->unit->id)
            ->get(['masalahs.*', 'forwards.unit_id AS unit_forwad_id', 'forwards.status AS forward_status', 'forwards.id AS forward_id']);

        $data = [
            'title' => 'Dashboard',
            'slug'  => 'dashboard',
            'number'  => 1,
            'selesai' => $this->getCount($collection, "selesai"),
            'proses' => $this->getCount($collection, "proses"),
            'total' => $this->getCount($collection, "total"),
            'lmlj_proses' => $this->getDataMasalah($collection, "proses"),
            'kotak_masuk' => $this->getKotakMasuk()
        ];

        // dd($data['kotak_masuk']);

        foreach ($data['lmlj_proses'] as $item) {
            if ($this->getTarget($item->jawaban) == 0) {
                $item->target = $this->getDefaultTarget($item->urgensi);
            } else {
                $item->target = $this->getTarget($item->jawaban);
            }
            $item->color = $this->getUrgensiColor($item->target);
            $item->text_status = $this->getStatusText($item->status);
            $item->color_status = $this->getStatusColor($item->status);
        }

        return view('dashboard.index', $data);
    }

    public function detail(Masalah $masalah)
    {

        auth()->user()->unit->masalah = $this->getKotakMasuk();

        // dd($masalah->jawaban->first());
        $pembagi = 1;
        if ($masalah->jawaban->count() > 0) {
            if ($masalah->jawaban->first()->status == 3) {
                $pembagi = 2;
            }
        }
        $masalah->target = $this->getDefaultTarget($masalah->urgensi);
        $masalah->color_urgensi = $this->getUrgensiColor($masalah->target);
        $lebar_status = $masalah->jawaban->count() ? 65 / ($masalah->jawaban->count() + $pembagi) : 50 - 1;
        // $lebar_status = if( $masalah->jawaban->count()==0) {50-1}  else{} ;
        $data = [
            'title' => 'Detail LMLJ',
            'slug'  => 'dashboard',
            'lebar_status' => $lebar_status . '%',
            'masalah' => $masalah,
            'kotak_masuk' => $this->getKotakMasuk(),
            'media_masalah' => $masalah->media,
            'detail_masalah' => $masalah->detailmasalah,
            'jawaban' => $masalah->jawaban,
            'number' =>  1
        ];
        foreach ($masalah->jawaban as $item) {
            $item->color_urgensi = $this->getUrgensiColor($item->target);
            $item->text_status = $this->getStatusText($item->status);
            $item->color_status = $this->getStatusColor($item->status);
        }
        // dd($masalah->jawaban->count());


        return view('lmlj.detail', $data);
    }

    public function selesai()
    {
        $pengaju_id = $this->getPengajuId();
        $collection = Masalah::with(['pengaju', 'diketahui', 'unit', 'jawaban'])
            ->leftJoin('forwards', 'masalahs.id', '=', 'forwards.masalah_id')
            ->where('masalahs.unit_id', auth()->user()->unit->id)
            ->orWhere('pengaju_id', $pengaju_id)
            ->orWhere('forwards.unit_id', auth()->user()->unit->id)
            ->get(['masalahs.*', 'forwards.unit_id AS unit_forwad_id']);
        $data = [
            'title' => 'LMLJ Selesai',
            'slug'  => 'dashboard',
            'number'  => 1,
            'selesai' => $this->getCount($collection, "selesai"),
            'proses' => $this->getCount($collection, "proses"),
            'total' => $this->getCount($collection, "total"),
            'lmlj_proses' => $this->getDataMasalah($collection, "selesai"),
            'kotak_masuk' => $this->getKotakMasuk()
        ];

        foreach ($data['lmlj_proses'] as $item) {
            if ($this->getTarget($item->jawaban) == 0) {
                $item->target = $this->getDefaultTarget($item->urgensi);
            } else {
                $item->target = $this->getTarget($item->jawaban);
            }
            $item->color = $this->getUrgensiColor($item->target);
            $item->text_status = $this->getStatusText($item->status);
            $item->color_status = $this->getStatusColor($item->status);
        }

        return view('dashboard.lmlj-selesai', $data);
    }
}
