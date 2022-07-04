<?php

namespace App\Http\Controllers;

use App\Models\DetailMasalah;
use App\Models\Komponen;
use Illuminate\Http\Request;
use App\Models\Masalah;
use App\Models\Produk;
use App\Models\Unit;
use App\Models\Media;

class PengajuanController extends Controller
{
    public function index()
    {
        // $kotak_masuk = $this->getKotakMasuk();
        $collection = Masalah::where('created_at', 'like', date('Y') . '%')
            ->get();
        // auth()->user()->unit->masalah = app('App\Http\Controllers\DashboardController')->getKotakMasuk();
        // auth()->user()->unit->masalah = $this->getKotakMasuk();
        // auth()->user()->unit->masalah = $this->model->
        // $collection = Masalah::all();
        // dd(auth()->user()->unit->masalah);
        $data = [
            'title'     => 'Pengajuan LMLJ',
            'slug'      => 'pengajuan-lmlj',
            'kotak_masuk' => $this->getKotakMasuk(),
            'number'    => 0,
            'nolmlj'    => $this->getNoLMLJ($collection),
            'produk'    => Produk::all(),
            'unit'      => Unit::where('id', '!=', auth()->user()->unit->id)->get(),
            'user'      => auth()->user(),
            'ygmengetahui' => auth()->user()->unit->user->where('role_id', 2)->first()
        ];
        // dd(auth()->user()->unit);

        // dd($data['ygmengetahui']);


        // dd($data);
        return view('lmlj.lembar-masalah', $data);
    }

    function store(Request $request)
    {
        $validated = $this->validate($request, [
            'media.*' => 'mimes:jpeg,png,mov,mp4,mkv,avi,jpg',
            'produk_id' => 'required',
            'masalah' => 'required',
            'unit_id' => 'required',

        ]);
        // dd($request->detail[0]);

        if ($validated) {
            $masalah_id = Masalah::orderBy('id', 'DESC')->first()->id + 1;
            if ($request->hasFile('media')) {
                $index = 1;
                foreach ($request->file('media') as $item) {
                    $id = sprintf("%02d", $index++);
                    $file_name = $item->getClientOriginalExtension();
                    $name = $request->nolmlj . '-M' . $id . '.' . $file_name;
                    $unit = explode("-", $name);
                    $item->move(public_path() . '/upload_media/masalah/' . $unit[0], $name);
                    $media['file'] = $name;
                    $media['masalah_id'] = $masalah_id;
                    Media::create($media);
                }
            }
            foreach ($request->detail as $item) {
                if ($item) {
                    $detail['masalah_id'] = $masalah_id;
                    $detail['detail'] = $item;
                    DetailMasalah::create($detail);
                }
            }
            Masalah::create($request->all());
        }
        return redirect(url('/dashboard'))->with('status', 'Lembar masalah berhasil dikirim! Menunggu konfirmasi!');



        // dd($request->all());

        // $masalah = masalah::create($request->all());
        // return response()->json(['msg' => 'Data created', 'data' => $masalah], 200);
    }

    public function getKomponenByProdukId($produk_id)
    {
        $data = Komponen::where('produk_id', $produk_id)->get();
        return response()->json($data);
    }
    public function getUnitTembusan($unit_user, $unit_id)
    {
        $data = Unit::where('id', '!=', $unit_user)->where('id', '!=', $unit_id)->get();
        return response()->json($data);
    }
    public function getProdukById(Produk $produk)
    {
        return response()->json($produk);
    }
    public function getKomponenById(Komponen $komponen)
    {
        return response()->json($komponen);
    }
}
