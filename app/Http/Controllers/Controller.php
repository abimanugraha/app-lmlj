<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



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
        $id = sprintf("%03d", ($collection->count() + 1));
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
        if ($urgensi == 1) {
            return "danger";
        } elseif ($urgensi == 2) {
            return "warning";
        } else {
            return "success";
        }
    }
    public function getStatusText($status)
    {
        if ($status == 0) {
            return "On Progres";
        } else {
            return "Selesai";
        }
    }
    public function getStatusColor($status)
    {
        if ($status == 0) {
            return "info";
        } else {
            return "success";
        }
    }
    public function getKotakMasuk()
    {
        $data = [];
        $masalah = auth()->user()->unit->masalah;
        foreach ($masalah as $item) {
            if ($item->jawaban->count() == 0) {
                $item->color = $this->getUrgensiColor($item->urgensi);
                $item->text_status = $this->getStatusText($item->status);
                $item->target = $this->getDefaultTarget($item->urgensi);
                $data[] = $item;
            }
        }
        return $data;
    }
    public function getTarget($collection)
    {
        return $collection->sum('target');
    }
    public function getCount($collection, $type)
    {
        if ($type == "selesai") {
            $filtered = $collection->whereBetween('created_at', [date('Y') . "-" . date('m') . "-00", date('Y') . "-" . date('m') . "-32"])->where('status', 1);
            return $filtered->count();
        } elseif ($type == "proses") {
            $month2 = (int)date('m') - 1;
            $last_month = str_replace(date('m'), "0" . $month2, date('m'));
            $filtered = $collection->whereBetween('created_at', [date('Y') . "-" . $last_month . "-00", date('Y') . "-" . date('m') . "-32"])->where('status', 0);
            return $filtered->count();
        } elseif ($type == "total") {
            $filtered = $collection->whereBetween('created_at', [date('Y') . "-" . date('m') . "-00", date('Y') . "-" . date('m') . "-32"]);
            return $filtered->count();
        }
    }
    public function getDataMasalah($collection, $type)
    {
        if ($type == "selesai") {
            $filtered = $collection->whereBetween('created_at', [date('Y') . "-" . date('m') . "-00", date('Y') . "-" . date('m') . "-32"])->where('status', 1);
            return $filtered;
        } elseif ($type == "proses") {
            $month2 = (int)date('m') - 1;
            $last_month = str_replace(date('m'), "0" . $month2, date('m'));
            $filtered = $collection->whereBetween('created_at', [date('Y') . "-" . $last_month . "-00", date('Y') . "-" . date('m') . "-32"])->where('status', 0);
            return $filtered;
        } elseif ($type == "total") {
            $filtered = $collection->whereBetween('created_at', [date('Y') . "-" . date('m') . "-00", date('Y') . "-" . date('m') . "-32"]);
            return $filtered;
        }
    }
}
