<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Masalah;
use App\Models\User;

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
        $pengaju_id = $this->getPengajuId();
        $query = Masalah::query();
        $query->leftJoin('forwards', 'masalahs.id', '=', 'forwards.masalah_id');
        $query->join('users', 'masalahs.pengaju_id', '=', 'users.id');
        $query->orwhere([['masalahs.unit_id', auth()->user()->unit->id], ['masalahs.status', 1]]);
        $query->orWhere([['forwards.unit_id', auth()->user()->unit->id], ['forwards.status', 3], ['masalahs.status', 3]]);
        if (auth()->user()->role_id == 2) {
            $query->orWhere([['masalahs.status', '>', 0], ['forwards.unit_id', auth()->user()->unit->id], ['forwards.status', 5]]);
            foreach ($pengaju_id as $id) {
                $query->orWhere([['masalahs.status', 0], ['masalahs.pengaju_id', $id]]);
            }
        }
        $result = $query->get(['masalahs.*', 'forwards.unit_id AS unit_forward_id', 'forwards.status AS forward_status', 'forwards.id AS forward_id'])->unique('id');
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
        if (auth()->user()->role_id == 2) {
            if ($type == "selesai") {
                $filtered = $collection->whereBetween('created_at', [date('Y') . "-" . date('m') . "-00", date('Y') . "-" . date('m') . "-32"])->where('status', 4);
                return $filtered->count();
            } elseif ($type == "proses") {
                $month2 = (int)date('m') - 1;
                $last_month = str_replace(date('m'), "0" . $month2, date('m'));
                $filtered = $collection->whereBetween('created_at', [date('Y') . "-" . $last_month . "-00", date('Y') . "-" . date('m') . "-32"])->where('status', '>=', 0)->where('status', '<', 4);
                return $filtered->count();
            } elseif ($type == "total") {
                $filtered = $collection->whereBetween('created_at', [date('Y') . "-" . date('m') . "-00", date('Y') . "-" . date('m') . "-32"]);
                return $filtered->count();
            }
        } else {
            if ($type == "selesai") {
                $filtered = $collection->whereBetween('created_at', [date('Y') . "-" . date('m') . "-00", date('Y') . "-" . date('m') . "-32"])->where('status', 4);
                return $filtered->count();
            } elseif ($type == "proses") {
                $month2 = (int)date('m') - 1;
                $last_month = str_replace(date('m'), "0" . $month2, date('m'));
                $filtered = $collection->whereBetween('created_at', [date('Y') . "-" . $last_month . "-00", date('Y') . "-" . date('m') . "-32"])->where('status', '>=', 0)->where('status', '<', 4);
                return $filtered->count();
            } elseif ($type == "total") {
                $filtered = $collection->whereBetween('created_at', [date('Y') . "-" . date('m') . "-00", date('Y') . "-" . date('m') . "-32"]);
                return $filtered->count();
            }
        }
    }
    public function getDataMasalah($collection, $type)
    {
        // dd($collection);
        if (auth()->user()->role_id == 2) {
            if ($type == "selesai") {
                $filtered = $collection->whereBetween('created_at', [date('Y') . "-" . date('m') . "-00", date('Y') . "-" . date('m') . "-32"])->where('status', 4);
                return $filtered;
            } elseif ($type == "proses") {
                $month2 = (int)date('m') - 1;
                $last_month = str_replace(date('m'), "0" . $month2, date('m'));
                $filtered = $collection->whereBetween('created_at', [date('Y') . "-" . $last_month . "-00", date('Y') . "-" . date('m') . "-32"])->where('status', '>=', 0)->where('status', '<', 4);
                return $filtered;
            } elseif ($type == "total") {
                $filtered = $collection->whereBetween('created_at', [date('Y') . "-" . date('m') . "-00", date('Y') . "-" . date('m') . "-32"])->where('status', '!=', 0);
                return $filtered;
            }
        } else {
            if ($type == "selesai") {
                $filtered = $collection->whereBetween('created_at', [date('Y') . "-" . date('m') . "-00", date('Y') . "-" . date('m') . "-32"])->where('status', 4);
                return $filtered;
            } elseif ($type == "proses") {
                $month2 = (int)date('m') - 1;
                $last_month = str_replace(date('m'), "0" . $month2, date('m'));
                $filtered = $collection->whereBetween('created_at', [date('Y') . "-" . $last_month . "-00", date('Y') . "-" . date('m') . "-32"])->where('status', '>=', 0)->where('status', '<', 4);
                return $filtered;
            } elseif ($type == "total") {
                $filtered = $collection->whereBetween('created_at', [date('Y') . "-" . date('m') . "-00", date('Y') . "-" . date('m') . "-32"]);
                return $filtered;
            }
        }
    }
}
