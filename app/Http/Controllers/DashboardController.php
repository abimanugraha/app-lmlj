<?php

namespace App\Http\Controllers;

use App\Models\Masalah;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // protected function viewDashboard()
    // {
    //     $temps = Masalah::all();
    //     for ($i = 0; $i < $temps->count(); $i++) {
    //         $data[$i]['year'] = $temps[$i]->created_at->format('Y');
    //         $data[$i]['month'] = $temps[$i]->created_at->format('m');
    //     }
    //     return $data;
    // }
    public function __construct()
    {
        // $user = $this->getKotakMasuk();
    }

    public function index()
    {
        // dd(auth()->user()->unit->masalah[2]->jawaban->count());
        // $collection = Masalah::with(['user', 'unit', 'jawaban'])->get();
        auth()->user()->unit->masalah = $this->getKotakMasuk();
        // dd(auth()->user());
        $collection = Masalah::with(['pengaju', 'diketahui', 'unit', 'jawaban'])
            ->where('unit_id', auth()->user()->unit->id)
            ->orWhere('pengaju_id', auth()->user()->id)
            ->get();
        // $usercollection = User::with(['unit', 'masalah'])->where('id', auth()->user()->id)->first();


        // dd($collection[0]->diketahui);
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
        // $data['selesai'] = $this->getCount($collection, "selesai");
        // $data['proses'] = $this->getCount($collection, "proses");
        // $data['total'] = $this->getCount($collection, "total");
        // $data['lmlj_proses'] = $this->getDataMasalah($collection, "proses");

        // dd($data['kotak_masuk']);


        // var_dump($data['lmlj_proses']);->append('links');
        // $data['lmlj_proses'][1]->append(['target' => 1]);
        // $collection->push('target');
        foreach ($data['lmlj_proses'] as $item) {
            if ($this->getTarget($item->jawaban) == 0) {
                $item->target = $this->getDefaultTarget($item->urgensi);
            } else {
                $item->target = $this->getTarget($item->jawaban);
            }
            $item->color = $this->getUrgensiColor($item->urgensi);
            $item->text_status = $this->getStatusText($item->status);
            $item->color_status = $this->getStatusColor($item->status);
            // $data['target'][] = $this->getTarget($item->jawaban);
            // $item->setAppends(['target' => $this->getTarget($item->jawaban)])->toArray();
            // $item->append(['target' => $this->getTarget($item->jawaban)]);
            // echo $item->id;
        }



        // dd($data['lmlj_proses']);
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


        // dd($data['kotak_masuk']);


        // return $collection->contains('2022-06');

        // return $temp->count();
        return view('dashboard.index', $data);
    }

    public function detail(Masalah $masalah)
    {
        auth()->user()->unit->masalah = $this->getKotakMasuk();
        // $collection = Masalah::with(['user', 'unit', 'jawaban'])
        //     ->where('nolmlj', $nolmlj)
        //     ->first();

        // dd($masalah);
        $lebar_status = $masalah->jawaban->count() ? 50 / $masalah->jawaban->count() : 50 - 1;
        // $lebar_status = if( $masalah->jawaban->count()==0) {50-1}  else{} ;
        $data = [
            'title' => 'Detail LMLJ',
            'slug'  => 'dashboard',
            'lebar_status' => $lebar_status . '%',
            'masalah' => $masalah,
            'media_masalah' => $masalah->media,
            'detail_masalah' => $masalah->detailmasalah,
            'jawaban' => $masalah->jawaban,
            'number' =>  1
        ];
        foreach ($masalah->jawaban as $item) {
            $item->color_urgensi = $this->getUrgensiColor($item->urgensi);
            $item->text_status = $this->getStatusText($item->status);
            $item->color_status = $this->getStatusColor($item->status);
        }
        // dd($masalah->jawaban->count());


        return view('lmlj.detail', $data);
    }
}
