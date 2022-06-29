<?php

namespace App\Http\Controllers;

use App\Models\Komponen;
use Illuminate\Http\Request;
use App\Models\Masalah;
use App\Models\Produk;

class PengajuanController extends Controller
{
    public function index()
    {
        // if ($_POST['input_nama_produk']) {
        //     $number = $_POST['input_nama_produk'];
        // } else {
        //     $number = 1;
        // }
        $collection = Masalah::where('created_at', 'like', date('Y') . '%')
            ->get();



        // auth()->user()->unit->masalah = app('App\Http\Controllers\DashboardController')->getKotakMasuk();
        auth()->user()->unit->masalah = $this->getKotakMasuk();
        // auth()->user()->unit->masalah = $this->model->
        // $collection = Masalah::all();
        // dd(auth()->user()->unit->masalah);
        $data = [
            'title'     => 'Pengajuan LMLJ',
            'slug'      => 'pengajuan-lmlj',
            'number'      => 0,
            'nolmlj'    => $this->getNoLMLJ($collection),
            'produk'    => Produk::all()
        ];

        // dd($data['produk'][0]);


        // dd($data);
        return view('lmlj.lembar-masalah', $data);
    }
}
