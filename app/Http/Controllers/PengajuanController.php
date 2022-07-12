<?php

namespace App\Http\Controllers;

use App\Models\DetailMasalah;
use App\Models\Forward;
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
        $collection = Masalah::where('created_at', 'like', date('Y') . '%')
            ->get();
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
        return view('lmlj.lembar-masalah-rev1', $data);
    }

    function store(Request $request)
    {

        dd($request->request);
        $validated = $this->validate($request, [
            'media.*' => 'mimes:jpeg,png,mov,mp4,mkv,avi,jpg',
            'produk_id' => 'required',
            'masalah' => 'required',
            'unit_id' => 'required',

        ]);

        if ($validated) {
            $masalah_id = Masalah::first();
            if ($masalah_id) {
                $masalah_id = Masalah::orderBy('id', 'DESC')->first()->id + 1;
            } else {
                $masalah_id = 1;
            }
            if ($request->hasFile('media')) {
                $index = 1;
                foreach ($request->file('media') as $item) {
                    $id = sprintf("%02d", $index++);
                    $file_name = $item->getClientOriginalExtension();
                    $name = $request->nolmlj . '-M' . $id . '.' . $file_name;
                    $unit = explode("-", $name);
                    $item->move(public_path() . '/upload_media/masalah/' . strtolower($unit[0]), $name);
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
            if ($request->forward) {
                foreach ($request->forward as $item) {
                    if ($item) {
                        $forward['masalah_id'] = $masalah_id;
                        $forward['unit_id'] = $item;
                        $forward['status'] = 5;
                        Forward::create($forward);
                    }
                }
            }
            Masalah::create($request->all());
        }
        return redirect(url('/dashboard'))->with('status', 'Lembar masalah berhasil dikirim! Menunggu konfirmasi!');
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
