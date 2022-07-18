<?php

namespace App\Http\Controllers;

use App\Models\Forward;
use App\Models\Lmlj;
use App\Models\Masalah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // $this->user = User::with(['unit'])->find(auth()->user()->id);
            $this->user = auth()->user();
            return $next($request);
        });
    }
    public function getCollectionMasalah()
    {
        $query = Masalah::query();
        $query->with(['pengaju', 'diketahui', 'unit', 'jawaban', 'user']);
        $query->leftJoin('lmljs', 'masalahs.lmlj_id', '=', 'lmljs.id');
        $query->leftJoin('forwards', 'masalahs.id', '=', 'forwards.masalah_id');
        $query->leftJoin('tembusans', 'lmljs.id', '=', 'tembusans.lmlj_id');
        $query->where('masalahs.created_at', '>', Carbon::now()->subDays(30));
        $query->where('lmljs.unit_pengaju_id', $this->user->unit->id);
        $query->orwhere([['masalahs.unit_tujuan_id', $this->user->unit->id], ['masalahs.status', '>', 0]]);
        $query->orwhere('forwards.unit_id', $this->user->unit->id);
        if ($this->user->role_id == 2) {
            $query->orwhere('tembusans.unit_id', $this->user->unit->id);
        }
        $list_get = [
            'masalahs.*',
            'lmljs.id AS lmlj_id',
            'lmljs.produk_id',
            'lmljs.pengaju_id',
            'lmljs.spv_pengaju_id',
            'lmljs.unit_pengaju_id',
            'tembusans.unit_id'

        ];
        return $query->get($list_get)->unique('id');
    }
    public function index()
    {

        $data_masalah = $this->getCollectionMasalah();
        $data_lmlj = $data_masalah->unique('lmlj_id');

        // dd($data_lmlj);
        $data = [
            'title' => 'Dashboard',
            'slug'  => 'dashboard',
            'number'  => 1,
            'selesai' => $this->getCount($data_lmlj, "selesai"),
            'proses' => $this->getCount($data_lmlj, "proses"),
            'total' => $this->getCount($data_lmlj, "total"),
            'lmlj_proses' => $this->getDataMasalah($data_masalah, "proses"),
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

        // dd($data['kotak_masuk']);

        return view('dashboard.index', $data);
    }

    public function detail(Masalah $masalah)
    {

        // auth()->user()->unit->masalah = $this->getKotakMasuk();
        $query = Masalah::query();
        $query->with(['lmlj', 'unit', 'jawaban', 'user']);
        $masalah = $query->find($masalah->id);

        // dd($masalah);
        // dd($masalah->lmlj->tembusan);
        $pembagi = 1;
        if ($masalah->forward->count() > 0) {
            $pembagi = $masalah->forward->count() + 1;
        }
        $masalah->target = $this->getDefaultTarget($masalah->urgensi);
        $masalah->color_urgensi = $this->getUrgensiColor($masalah->target);
        $masalah->color_realisasi = $this->getUrgensiColor($masalah->created_at->diffInDays($masalah->updated_at));
        $lebar_status = $masalah->jawaban->count() ? 65 / (1 + $pembagi) : 50 - 1;
        // dd($pembagi);
        // dd($masalah->jawaban->count());
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
        // dd($masalah->forward);


        return view('lmlj.detail', $data);
    }

    public function selesai()
    {
        $collection = $this->getCollectionMasalah();
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
