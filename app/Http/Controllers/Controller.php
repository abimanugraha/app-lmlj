<?php

namespace App\Http\Controllers;

use App\Models\Lmlj;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Masalah;
use App\Models\Produk;
use App\Models\User;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function getPengajuId()
    {
        $unit = auth()->user()->unit;
        $user = $unit->user;
        foreach ($user as $item) {
            $id[] = $item->id;
        }
        return $id;
    }
    public function getPenerimaId()
    {
        $unit = auth()->user()->unit;
        $user = $unit->user;
        foreach ($user as $item) {
            $id[] = $item->id;
        }
        return $id;
    }

    public function getUrgensiByTarget($target)
    {
        if ($target <= 3) {
            return 1;
        } elseif ($target > 3 && $target <= 7) {
            return 2;
        } else {
            return 3;
        }
    }

    public function getNoLMLJ($collection)
    {
        $unit   = strtoupper(auth()->user()->unit->unit);
        $kode   = 'LMLJ';
        $year   = date('y');
        $month  = date('m');
        $id = sprintf("%04d", ($collection->count() + 1));
        return $unit . "-" . $kode . "-" . $month . "-" . $year . "-" . $id;
    }
    public function getDefaultTarget($urgensi)
    {
        if ($urgensi == 1) {
            return 3;
        } elseif ($urgensi == 2) {
            return 7;
        } else {
            return 14;
        }
    }
    public function getUrgensiColor($urgensi)
    {
        if ($urgensi <= 3) {
            return "danger";
        } elseif ($urgensi > 3 && $urgensi <= 7) {
            return "warning";
        } else {
            return "success";
        }
    }
    public function getStatusText($status)
    {
        if ($status == 0) {
            return "Menunggu Konfirmasi";
        } else if ($status == 1) {
            return "Menunggu Respon";
        } else if ($status == 2) {
            return "On Progress";
        } else if ($status == 3) {
            return "Forwarding";
        } else if ($status == 4) {
            return "Selesai";
        }
    }
    public function getStatusColor($status)
    {
        if ($status == 0) {
            return "light";
        } else if ($status > 0 && $status < 3) {
            return "warning";
        } else if ($status == 3) {
            return "danger";
        } else {
            return "success";
        }
    }
    public function getKotakMasuk()
    {
        $query = Masalah::query();
        $query->join('lmljs', 'masalahs.lmlj_id', '=', 'lmljs.id');
        $query->leftJoin('forwards', 'masalahs.id', '=', 'forwards.masalah_id');
        $query->leftJoin('tembusans', 'lmljs.id', '=', 'tembusans.lmlj_id');

        // Pengkondisian
        $query->where([['masalahs.unit_tujuan_id', auth()->user()->unit->id], ['masalahs.status', '>', 0], ['masalahs.status', '<', 4]]);
        $query->orwhere([['forwards.unit_id', auth()->user()->unit->id], ['forwards.status', 0]]);
        if (auth()->user()->role_id == 2) {
            $query->orwhere([['lmljs.unit_pengaju_id', auth()->user()->unit->id], ['masalahs.status', 0]]);
            $query->orwhere([['forwards.unit_id', auth()->user()->unit->id], ['forwards.status', 2]]);
            $query->orwhere([['tembusans.unit_id', auth()->user()->unit->id], ['tembusans.status', 0]]);
        }

        $list_get = [
            'masalahs.*',
            'lmljs.id AS lmlj_id',
            'lmljs.produk_id',
            'lmljs.pengaju_id',
            'lmljs.spv_pengaju_id',
            'lmljs.unit_pengaju_id',
            'tembusans.id AS tembusan_id',
            'tembusans.unit_id AS unit_tembusan_id',
            'tembusans.status AS status_tembusan',
            'forwards.unit_id AS unit_forward_id',
            'forwards.status AS status_forward'
        ];


        $result = $query->get($list_get)->unique('id');
        foreach ($result as $item) {
            $item->target = $this->getDefaultTarget($item->urgensi);
            $item->color = $this->getUrgensiColor($item->target);
            $item->text_status = $this->getStatusText($item->status);
        }
        // dd($result);

        return $result;
    }
    public function getTarget($collection)
    {
        return $collection->sum('target');
    }


    public function getCount($collection, $type)
    {
        if ($type == "selesai") {
            $filtered = $collection->where('status', 4);
            return $filtered->count();
        } elseif ($type == "proses") {
            $month2 = (int)date('m') - 1;
            $filtered = $collection->where('status', '>=', 0)->where('status', '<', 4);
            return $filtered->count();
        } elseif ($type == "total") {
            $filtered = $collection->where('created_at', '>', Carbon::now()->subDays(Carbon::now()->day));
            $filtered = $filtered->where('status', '<', 5);
            return $filtered->count();
        }
    }
    public function getDataMasalah($collection, $type)
    {
        // dd($collection);
        if ($type == "selesai") {
            $filtered = $collection->where('status', 4);
            return $filtered;
        } elseif ($type == "proses") {
            $month2 = (int)date('m') - 1;
            $filtered = $collection->where('status', '>=', 0)->where('status', '<', 4);
            return $filtered;
        } elseif ($type == "total") {
            $filtered = $collection->where('created_at', '>', Carbon::now()->subDays(Carbon::now()->day));
            return $filtered;
        }
    }
    public function getProduk()
    {
        $data = Produk::all();
        return response()->json($data);
    }
    public function editproduk($lmlj_id, $produk_id)
    {
        $lmlj = Lmlj::find($lmlj_id);
        $lmlj->produk_id = (int)$produk_id;
        $result = [
            'nama' => $lmlj->produk->nama,
            'nomor' => $lmlj->produk->nomor,
        ];
        $lmlj->save();
        return response()->json($result);
    }
}
