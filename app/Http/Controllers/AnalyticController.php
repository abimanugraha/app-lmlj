<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Lmlj;
use Illuminate\Http\Request;
use App\Models\Masalah;
use App\Models\Tembusan;
use App\Models\Produk;
use Nette\Utils\Json;
use Illuminate\Support\Carbon;

class AnalyticController extends Controller
{
    public function getTime($type, $month)
    {
        $temp_respon = 0;
        $temp_finish = 0;
        $avg_respon = 0;
        $avg_finish = 0;
        $query = Masalah::query();
        $query->join('jawabans', 'masalahs.id', '=', 'jawabans.masalah_id');
        $query->where('jawabans.status', 4);
        $query->where('masalahs.unit_tujuan_id', auth()->user()->unit->id);
        $query->whereMonth('masalahs.created_at', '=', $month);
        $collection = $query->get(['masalahs.tanggal_acc', 'jawabans.created_at', 'jawabans.updated_at']);
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

    public function getDataChartLmlj($year)
    {
        $query = Masalah::query();
        $query->join('lmljs', 'masalahs.lmlj_id', '=', 'lmljs.id');
        $query->leftJoin('forwards', 'masalahs.id', '=', 'forwards.masalah_id');
        $query->leftJoin('tembusans', 'lmljs.id', '=', 'tembusans.lmlj_id');

        // $query->whereYear('updated_at', $year);
        $query->where([['masalahs.unit_tujuan_id', auth()->user()->unit->id], ['masalahs.status', '>', 0]])->whereYear('masalahs.updated_at', $year);
        $query->orwhere('forwards.unit_id', auth()->user()->unit->id)->whereYear('masalahs.updated_at', $year);
        $query->orwhere('lmljs.unit_pengaju_id', auth()->user()->unit->id)->whereYear('masalahs.updated_at', $year);
        if (auth()->user()->role_id == 2) {
            $query->orwhere('tembusans.unit_id', auth()->user()->unit->id)->whereYear('masalahs.updated_at', $year);
        }
        $list_get = [
            'masalahs.id',
            'masalahs.updated_at',
        ];
        $collection = $query->get($list_get)->unique('id');
        // dd($collection);

        $filtered = $collection->groupBy((function ($date) {
            return Carbon::parse($date->updated_at)->format('m');
        }));


        $datainmonth = [];
        $data_every_month = [];

        foreach ($filtered as $key => $value) {
            $datainmonth[(int)$key] = $value->count();
        }

        for ($i = 1; $i <= 12; $i++) {
            if (!empty($datainmonth[$i])) {
                $data_every_month[$i] = $datainmonth[$i];
            } else {
                $data_every_month[$i] = 0;
            }
        }

        // dd($data_every_month);
        return response()->json($data_every_month);
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

    public function getOnTarget($month)
    {
        $completed = Jawaban::where([['unit_id', auth()->user()->unit->id], ['status', 4]])->whereMonth('created_at', '=', $month)->get();
        $ontarget = 0;
        foreach ($completed as $item) {
            $diff = date_diff($item->updated_at, $item->created_at);
            if ($diff->d <= $item->target) {
                $ontarget++;
            }
        }

        $nilai_ontarget = 0;
        if ($completed->count() > 0) {
            $nilai_ontarget = $ontarget / $completed->count() * 100;
        }
        return $nilai_ontarget . '%';
    }

    public function getPerforma($month)
    {
        // Nilai ketepatan menyelesaikan masalah
        $completed = Jawaban::where([['unit_id', auth()->user()->unit->id], ['status', 4]])->whereMonth('created_at', '=', $month)->get();
        $ontarget = 0;
        foreach ($completed as $item) {
            $diff = date_diff($item->updated_at, $item->created_at);
            if ($diff->d <= $item->target) {
                $ontarget++;
            }
        }

        $nilai_ontarget = 70;
        if ($completed->count() > 0) {
            $nilai_ontarget = $ontarget / $completed->count() * 70;
        }

        // Nilai respon time
        $temp_respon = 0;
        $query = Masalah::query();
        $query->join('jawabans', 'masalahs.id', '=', 'jawabans.masalah_id');
        $query->where('jawabans.status', 4);
        $query->where('masalahs.unit_tujuan_id', auth()->user()->unit->id);
        $query->whereMonth('masalahs.created_at', '=', date('m'));
        $respon_jawaban = $query->get(['masalahs.tanggal_acc', 'jawabans.created_at']);
        $nilai_respon_jawaban = 20;
        if ($respon_jawaban->count() > 0) {
            foreach ($respon_jawaban as $item) {
                $temp_respon += (strtotime($item->created_at) - strtotime($item->tanggal_acc));
            }
            $nilai_respon_jawaban = $temp_respon / $respon_jawaban->count();
            if ($nilai_respon_jawaban <= 10800) {
                $nilai_respon_jawaban = 1;
            } elseif ($nilai_respon_jawaban > 10800 && $nilai_respon_jawaban <= 21600) {
                $nilai_respon_jawaban = 0.9;
            } elseif ($nilai_respon_jawaban > 21600 && $nilai_respon_jawaban <= 32400) {
                $nilai_respon_jawaban = 0.8;
            } elseif ($nilai_respon_jawaban > 32400 && $nilai_respon_jawaban <= 43200) {
                $nilai_respon_jawaban = 0.7;
            } elseif ($nilai_respon_jawaban > 43200 && $nilai_respon_jawaban <= 54000) {
                $nilai_respon_jawaban = 0.6;
            } elseif ($nilai_respon_jawaban > 54000 && $nilai_respon_jawaban <= 64800) {
                $nilai_respon_jawaban = 0.5;
            }
            $nilai_respon_jawaban = $nilai_respon_jawaban * 20;
        }

        // Nilai respon tembusan
        $temp_respon = 0;
        $tembusan = Tembusan::where('unit_id', auth()->user()->unit->id)->get();
        if ($tembusan->count() == 0) {
            $nilai_respon_tembusan = 10;
        } else {
            foreach ($tembusan as $item) {
                $temp_respon = $temp_respon + strtotime($item->updated_at) - strtotime($item->created_at);
            }
            $nilai_respon_tembusan = $temp_respon / $tembusan->count();
            if ($nilai_respon_tembusan <= 10800) {
                $nilai_respon_tembusan = 1;
            } elseif ($nilai_respon_tembusan > 10800 && $nilai_respon_tembusan <= 21600) {
                $nilai_respon_tembusan = 0.9;
            } elseif ($nilai_respon_tembusan > 21600 && $nilai_respon_tembusan <= 32400) {
                $nilai_respon_tembusan = 0.8;
            } elseif ($nilai_respon_tembusan > 32400 && $nilai_respon_tembusan <= 43200) {
                $nilai_respon_tembusan = 0.7;
            } elseif ($nilai_respon_tembusan > 43200 && $nilai_respon_tembusan <= 54000) {
                $nilai_respon_tembusan = 0.6;
            } elseif ($nilai_respon_tembusan > 54000 && $nilai_respon_tembusan <= 64800) {
                $nilai_respon_tembusan = 0.5;
            }
            $nilai_respon_tembusan = $nilai_respon_tembusan * 10;
        }

        $total = $nilai_ontarget + $nilai_respon_jawaban + $nilai_respon_tembusan;
        if ($total >= 80) {
            $result = [
                'nilai' => 'A',
                'warna' => 'success',
                'keterangan' => 'Sangat Baik',
            ];
        } elseif ($total < 80 && $total >= 70) {
            $result = [
                'nilai' => 'B',
                'warna' => 'info',
                'keterangan' => 'Baik',
            ];
        } elseif ($total < 70 && $total >= 60) {
            $result = [
                'nilai' => 'C',
                'warna' => 'warning',
                'keterangan' => 'Cukup Baik',
            ];
        } else {
            $result = [
                'nilai' => 'D',
                'warna' => 'danger',
                'keterangan' => 'Kurang Baik',
            ];
        }
        // dd($result);
        return (object)$result;
    }

    public function getDataStatistics($month)
    {
        $result = $this->getCountLmljbyMonth($month);
        $result['respon_time'] = $this->getTime('respon', $month);
        $result['finish'] = $this->getOnTarget($month);
        $result['performa'] = $this->getPerforma($month);
        return response()->json($result);
    }

    public function index()
    {
        $total = $this->getCountLmljbyMonth(date('m'));
        $total['respon_time'] = $this->getTime('respon', date('m'));
        $total['finish'] = $this->getOnTarget(date('m'));

        // dd($total);
        $data = [
            'title' => 'Analisa unit ' . auth()->user()->unit->unit,
            'slug'  => 'analytics',
            'kotak_masuk' => $this->getKotakMasuk(),
            'number' => 1,
            'total' => $total,
            'produk' => $this->getAnalisisProduk(),
            'performa' => $this->getPerforma(date('m'))
        ];

        return view('lmlj.analytics-lmlj', $data);
    }
}
