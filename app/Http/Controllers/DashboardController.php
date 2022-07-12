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
        $query = Masalah::query();
        $query->with(['pengaju', 'diketahui', 'unit', 'jawaban']);
        $query->leftJoin('forwards', 'masalahs.id', '=', 'forwards.masalah_id');
        $query->where('masalahs.unit_id', auth()->user()->unit->id);
        $query->orWhere([['forwards.unit_id', auth()->user()->unit->id], ['forwards.status', 3]]);
        if (auth()->user()->role_id == 2) {
            $query->orWhere([['masalahs.status', '>', 0], ['forwards.unit_id', auth()->user()->unit->id], ['forwards.status', '>=', 5]]);
        }
        foreach ($pengaju_id as $id) {
            $query->orWhere([['masalahs.pengaju_id', $id]]);
        }
        $collection = $query->get(['masalahs.*', 'forwards.unit_id AS unit_forward_id', 'forwards.status AS forward_status', 'forwards.id AS forward_id'])->unique('id');
        // $collection = Masalah::with(['pengaju', 'diketahui', 'unit', 'jawaban'])
        //     ->leftJoin('forwards', 'masalahs.id', '=', 'forwards.masalah_id')
        //     ->where('masalahs.unit_id', auth()->user()->unit->id)
        //     ->orWhere('masalahs.pengaju_id', $pengaju_id)
        //     ->orWhere('forwards.unit_id', auth()->user()->unit->id)
        //     ->get(['masalahs.*', 'forwards.unit_id AS unit_forwad_id', 'forwards.status AS forward_status', 'forwards.id AS forward_id']);

        foreach ($collection as $item) {
            if ($item->forward_status == null) {
                $item->forward_status = 3;
            }
            // echo $item->nolmlj . '-------->' . $item->unit->unit;
            // echo "<br>";
            // echo $item->forward_status;
            // echo "<br>";
            // echo "<br>";
        }
        // dd($collection);
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

        // dd($data['lmlj_proses']);

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

        // auth()->user()->unit->masalah = $this->getKotakMasuk();

        // dd($masalah->forward);
        $pembagi = 1;
        if ($masalah->jawaban->count() > 0) {
            if ($masalah->jawaban->first()->status == 3) {
                $pembagi = 2;
            }
        }
        $masalah->target = $this->getDefaultTarget($masalah->urgensi);
        $masalah->color_urgensi = $this->getUrgensiColor($masalah->target);
        $masalah->color_realisasi = $this->getUrgensiColor($masalah->created_at->diffInDays($masalah->updated_at));
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
        $query = Masalah::query();
        $query->with(['pengaju', 'diketahui', 'unit', 'jawaban']);
        $query->leftJoin('forwards', 'masalahs.id', '=', 'forwards.masalah_id');
        $query->where('masalahs.unit_id', auth()->user()->unit->id);
        $query->orWhere([['forwards.unit_id', auth()->user()->unit->id], ['forwards.status', 3]]);
        if (auth()->user()->role_id == 2) {
            $query->orWhere([['masalahs.status', '>', 0], ['forwards.unit_id', auth()->user()->unit->id], ['forwards.status', '>=', 5]]);
        }
        foreach ($pengaju_id as $id) {
            $query->orWhere([['masalahs.pengaju_id', $id]]);
        }
        $collection = $query->get(['masalahs.*', 'forwards.unit_id AS unit_forward_id', 'forwards.status AS forward_status', 'forwards.id AS forward_id'])->unique('id');
        $data = [
            'title' => 'LMLJ Selesai',
            'slug'  => 'dashboard',
            'number'  => 1,
            'selesai' => $this->getCount($collection, "selesai"),
            'proses' => $this->getCount($collection, "proses"),
            'total' => $this->getCount($collection, "total"),
            'lmlj_selesai' => $this->getDataMasalah($collection, "selesai"),
            'kotak_masuk' => $this->getKotakMasuk()
        ];

        foreach ($data['lmlj_selesai'] as $item) {
            if ($this->getTarget($item->jawaban) == 0) {
                $item->target = $this->getDefaultTarget($item->urgensi);
            } else {
                $item->target = $this->getTarget($item->jawaban);
            }
            $item->color = $this->getUrgensiColor($item->target);
            $item->color_realisasi = $this->getUrgensiColor($item->created_at->diffInDays($item->updated_at));
            $item->text_status = $this->getStatusText($item->status);
            $item->color_status = $this->getStatusColor($item->status);
        }

        return view('dashboard.lmlj-selesai', $data);
    }
}
