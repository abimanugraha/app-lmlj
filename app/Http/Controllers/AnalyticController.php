<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Lmlj;
use Illuminate\Http\Request;
use App\Models\Masalah;
use App\Models\Tembusan;
use App\Models\Produk;
use Nette\Utils\Json;

class AnalyticController extends Controller
{
    //
    public function getCollection()
    {
        $query = Masalah::query();
        $query->join('lmljs', 'masalahs.lmlj_id', '=', 'lmljs.id');
        $query->leftJoin('forwards', 'masalahs.id', '=', 'forwards.masalah_id');
        $query->leftJoin('tembusans', 'lmljs.id', '=', 'tembusans.lmlj_id');

        // Pengkondisian
        $query->where([['masalahs.unit_tujuan_id', auth()->user()->unit->id], ['masalahs.status', '>', 0]]);
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

    public function getTime($type)
    {
        $query = Masalah::query();
        $query->join('jawabans', 'masalahs.id', '=', 'jawabans.masalah_id');
        $query->where('jawabans.status', 4);
        $query->where('masalahs.unit_tujuan_id', auth()->user()->unit->id);
        $collection = $query->get(['masalahs.tanggal_acc', 'jawabans.created_at', 'jawabans.updated_at']);
        $temp_respon = 0;
        $temp_finish = 0;
        $avg_respon = 0;
        $avg_finish = 0;
        foreach ($collection as $item) {
            $temp_respon = $temp_respon + (strtotime($item->created_at) - strtotime($item->tanggal_acc));
            $temp_finish = $temp_finish + abs(strtotime($item->created_at) - strtotime($item->updated_at));
        }

        $tembusan = Tembusan::where('unit_id', auth()->user()->unit->id)->get();
        foreach ($tembusan as $item) {
            $temp_respon = $temp_respon + abs(strtotime($item->created_at) - strtotime($item->updated_at));
        }

        if ($collection->count() || $tembusan->count()) {
            $avg_respon = $temp_respon / ($collection->count() + $tembusan->count());
        }
        if ($collection->count()) {
            $avg_finish = $temp_finish / $collection->count();
        }

        if ($type == 'respon') {
            if ($avg_respon / (60 * 60) < 1) {
                return floor($avg_respon / (60)) . 'm';
            } else {
                return floor($avg_respon / (60 * 60)) . 'h';
            }
        } else {
            if ($avg_finish / (60 * 60) < 1) {
                return floor($avg_finish / (60)) . 'm';
            } else {
                return floor($avg_finish / (60 * 60)) . 'h';
            }
        }
    }

    public function getAnalisisProduk()
    {
        $query = Produk::query();
        $query->with('lmlj');
        $collection  = $query->get();
        foreach ($collection as $item) {
            $item->total_lmlj = $item->lmlj->count();
        }
        // dd($collection->sortByDesc('total_lmlj')->take(3));

        return $collection->sortByDesc('total_lmlj')->take(5);
    }

    public function getHistoryLmljbyYear($year)
    {

        $jan = 0;
    }

    public function getCountLmljbyMonth($month)
    {
        $pengajuan = Lmlj::where('unit_pengaju_id', auth()->user()->unit->id)->whereMonth('created_at', '=', $month)->count();
        $completed = Jawaban::where([['unit_id', auth()->user()->unit->id], ['status', 4]])->whereMonth('created_at', '=', $month)->count();
        $tembusan = Tembusan::where([['unit_id', auth()->user()->unit->id], ['status', 1]])->whereMonth('created_at', '=', $month)->count();
        $total['pengajuan'] = $pengajuan;
        $total['completed'] = $completed;
        $total['tembusan'] = $tembusan;
        $total['total'] = $pengajuan + $completed + $tembusan;
        return $total;
    }

    public function index()
    {

        $total = $this->getCountLmljbyMonth(date('m'));
        $total['respon_time'] = $this->getTime('respon');
        $total['finish'] = $this->getTime('finish');

        // dd($total);
        $data = [
            'title' => 'Analisa unit ' . auth()->user()->unit->unit,
            'slug'  => 'analytics',
            'kotak_masuk' => $this->getKotakMasuk(),
            'number' => 1,
            'total' => $total,
            'produk' => $this->getAnalisisProduk()
        ];

        return view('lmlj.analytics-lmlj', $data);
    }
}
