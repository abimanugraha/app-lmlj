<?php

namespace App\Http\Controllers;

use App\Models\DetailMasalah;
use App\Models\Masalah;
use App\Models\Produk;
use App\Models\Komponen;
use App\Models\Unit;
use App\Models\Media;
use App\Models\Tembusan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class KotakKeluarController extends Controller
{
    //
    public function getCollection()
    {
        $query = Masalah::query();
        $query->join('lmljs', 'masalahs.lmlj_id', '=', 'lmljs.id');
        $query->leftJoin('forwards', 'masalahs.id', '=', 'forwards.masalah_id');
        $query->leftJoin('tembusans', 'lmljs.id', '=', 'tembusans.lmlj_id');

        // Pengkondisian
        $query->where([['lmljs.unit_pengaju_id', auth()->user()->unit->id], ['masalahs.status', '<=', 1]]);
        $query->orwhere([['lmljs.unit_pengaju_id', auth()->user()->unit->id], ['masalahs.status', 10]]);
        $query->with('lmlj', 'unit');

        $collection = $query->get('masalahs.*')->unique('id');
        return $collection;
    }

    public function index()
    {
        $collection = $this->getCollection();
        $data = [
            'title' => 'Kotak Keluar LMLJ',
            'slug'  => 'kotak-keluar-lmlj',
            'masalah' => $collection,
            'kotak_masuk' => $this->getKotakMasuk(),
            'produk'    => Produk::all(),
            'number' => 1,
        ];

        return view('lmlj.kotak-keluar-lmlj', $data);
    }


    public function deletelmlj($id)
    {
        $masalah = Masalah::find($id);
        $masalah->status = 10;
        $masalah->save();
        return response()->json($masalah);
    }
    public function deletelampiran($id)
    {
        $media = Media::find($id);
        Media::destroy($id);
        $path = explode('-', $media->file)[0];
        Storage::delete('upload_media/masalah/' . $path . '/' . $media->file);
        // Storage::delete('upload_media/masalah/' . $path . '/user.png');
        // $media->save();
        return response()->json($media);
    }
    public function turnonlmlj($id)
    {
        $masalah = Masalah::find($id);
        $masalah->status = 1;
        $masalah->save();
        return response()->json($masalah);
    }

    public function getListUnit($allmasalah, $nolmlj)
    {
        $without = $allmasalah->where('nolmlj', '!=', $nolmlj);
        $without_id = [auth()->user()->unit->id];
        foreach ($without as $item) {
            $without_id[] = $item->unit_tujuan_id;
        }
        return $without_id;
    }

    public function getListTembusan($tembusan)
    {
        $data = [];
        foreach ($tembusan as $item) {
            $data[] = $item->unit_id;
        }
        return json_encode($data);
    }

    public function edit($nolmlj)
    {
        $masalah = Masalah::where('nolmlj', $nolmlj)->first();
        $unit = Unit::whereNotIn('id', $this->getListUnit($masalah->lmlj->masalah, $nolmlj))->get();
        $unit_tembusan = Unit::whereNotIn('id', [auth()->user()->unit->id, $masalah->unit_tujuan_id])->get();
        $tembusan = $this->getListTembusan($masalah->lmlj->tembusan);

        // dd($masalah->detailmasalah);

        // dd($tembusan);
        $data = [
            'title' => 'Edit LMLJ',
            'slug'  => 'kotak-keluar-lmlj',
            'kotak_masuk' => $this->getKotakMasuk(),
            'masalah' => $masalah,
            'unit' => $unit,
            'unit_tembusan' => $unit_tembusan,
            'tembusan' => $tembusan,
            'produk' => Produk::all(),
            'komponen' => Komponen::all(),
            'detail' => $masalah->detailmasalah,
        ];


        return view('lmlj.edit-lmlj', $data);
    }

    public function editmasalah(Request $request)
    {

        // Update data masalah
        $masalah = Masalah::find($request->masalah_id);
        $masalah->unit_tujuan_id = $request->unit_tujuan_id;
        $masalah->komponen_id = $request->komponen_id;
        $masalah->komponen_id = $request->komponen_id;
        $masalah->masalah = $request->masalah;
        $masalah->masalah = $request->masalah;
        $masalah->nilai_tambah = $request->nilai_tambah;
        $masalah->nilai_tambah = $request->nilai_tambah;
        $masalah->urgensi = $request->urgensi;
        $masalah->save();


        // Update data lmlj
        $lmlj = $masalah->lmlj;
        $lmlj->produk_id = $request->produk_id;
        $lmlj->save();

        // Update data detail masalah
        $detail = $masalah->detailmasalah;
        foreach ($detail as $item) {
            DetailMasalah::destroy($item->id);
        }
        if ($request->detail) {
            foreach ($request->detail as $item) {
                $data_detail = [
                    'masalah_id' => $request->masalah_id,
                    'detail' => $item
                ];
                DetailMasalah::create($data_detail);
            }
        }

        // Update data tembusan
        $tembusan = $lmlj->tembusan;
        foreach ($tembusan as $item) {
            Tembusan::destroy($item->id);
        }
        if ($request->tembusan) {
            foreach ($request->tembusan as $item) {
                $data_tembusan = [
                    'lmlj_id' => $lmlj->id,
                    'unit_id' => $item,
                    'status' => 0,
                ];
                Tembusan::create($data_tembusan);
            }
        }

        // Update media
        if ($request->hasFile('media')) {
            $index = 1;
            $media = Media::where('masalah_id', $masalah->id)->orderBy('file', 'DESC')->first();
            if ($media) {
                $index = substr(explode('.', $media->file)[0], -1);
                $index++;
            }
            foreach ($request->file('media') as $item) {
                $id = sprintf("%02d", $index++);
                $file_name = $item->getClientOriginalExtension();
                $name = $masalah->lmlj->nolmlj . '-M' . $request->masalah_id . '-' . $id . '.' . $file_name;
                $unit = explode("-", $name);
                $item->move(public_path() . '/storage/upload_media/masalah/' . $unit[0], $name);
                $data_media = [
                    'masalah_id' => $request->masalah_id,
                    'file' => $name,
                ];
                Media::create($data_media);
            }
        }

        $pesan = 'Lembar masalah berhasil diedit!';
        return redirect(url('/edit/' . $masalah->nolmlj))->with('status', $pesan);
    }
}
