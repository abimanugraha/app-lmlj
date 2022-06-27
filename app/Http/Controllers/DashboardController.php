<?php

namespace App\Http\Controllers;

use App\Models\Masalah;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected function viewDashboard()
    {
        $temps = Masalah::all();
        for ($i = 0; $i < $temps->count(); $i++) {
            $data[$i]['year'] = $temps[$i]->created_at->format('Y');
            $data[$i]['month'] = $temps[$i]->created_at->format('m');
        }
        return $data;
    }

    public function index()
    {
        $collection = Masalah::with(['user', 'unit', 'jawaban'])->get();
        $usercollection = User::with(['unit', 'masalah'])->where('username', auth()->user()->username)->first();
        dd($usercollection->unit->masalah);
        $data = [
            'title' => 'Dashboard',
            'slug'  => 'dashboard',
            'number'  => 1,
            'selesai' => $this->getCount($collection, "selesai"),
            'proses' => $this->getCount($collection, "proses"),
            'total' => $this->getCount($collection, "total"),
            'lmlj_proses' => $this->getDataMasalah($collection, "proses"),
            // 'kotak_masuk' => $this->getKotakMasuk($usercollection)
        ];
        // $data['selesai'] = $this->getCount($collection, "selesai");
        // $data['proses'] = $this->getCount($collection, "proses");
        // $data['total'] = $this->getCount($collection, "total");
        // $data['lmlj_proses'] = $this->getDataMasalah($collection, "proses");


        // var_dump($data['lmlj_proses']);->append('links');
        // $data['lmlj_proses'][1]->append(['target' => 1]);
        // $collection->push('target');
        foreach ($data['lmlj_proses'] as $item) {
            $item->target = $this->getTarget($item->jawaban);
            // $data['target'][] = $this->getTarget($item->jawaban);
            // $item->setAppends(['target' => $this->getTarget($item->jawaban)])->toArray();
            // $item->append(['target' => $this->getTarget($item->jawaban)]);
            // echo $item->id;
        }
        // for ($i = 0; $i < $data['lmlj_proses']->count(); $i++) {
        //     echo $data['lmlj_proses'][$i];
        // }

        // $data['lmlj_proses']->put('target', $data['target']);
        // dd($data['lmlj_proses']);
        // return $collection;
        // for ($i = 0; $i < $collection->count(); $i++) {
        //     if ($collection[$i]->contains('created_at', '2022-06')) {
        //         echo $collection[$i];
        //     }
        // }
        // return $data;

        // $year = date('Y-m-d');
        // $month1 = (int)date('m') - 1;
        // $month2 = (int)date('m') - 2;
        // $last_1month = str_replace(date('m'), "0" . $month1, now());
        // $last_2month = str_replace(date('m'), "0" . $month2, now());

        // echo substr(strrchr($year, $month),0,2);
        // echo $last_1month;
        // echo $last_2month;

        // $filtered = $collection->whereBetween('created_at', [date('Y') . "-" . date('m') . "-00", date('Y') . "-" . date('m') . "-32"])->where('status', 1);
        // return $filtered;

        // $selesai = $filtered->countBy(function ($item) {
        //     return $item['status'];
        // });
        // $count = $collection->countBy(function ($item) {
        //     return substr($item['created_at'], 0, 7);
        // });


        dd($data['kotak_masuk']);


        // return $collection->contains('2022-06');

        // return $temp->count();
        return view('dashboard.index', $data);
    }


    public function getKotakMasuk($collection)
    {
        return $collection->masalah;
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
