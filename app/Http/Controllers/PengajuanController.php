<?php

namespace App\Http\Controllers;

use App\Models\DetailMasalah;
use App\Models\Forward;
use App\Models\Komponen;
use App\Models\Lmlj;
use Illuminate\Http\Request;
use App\Models\Masalah;
use App\Models\Produk;
use App\Models\Unit;
use App\Models\Media;
use App\Models\Tembusan;
use App\Models\Complaint;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class PengajuanController extends Controller
{

    public function test()
    {
        $url = 'http://28.11.5.6/support-user/monitoring-complaint/images/foto/WhatsApp%20Image%202022-08-03%20at%2011.58.00%20AM.jpeg';
        $info = pathinfo($url);
        $contents = file_get_contents($url);
        $file = '/opt/lampp/temp/' . $info['basename'];
        file_put_contents($file, $contents);
        $uploaded_file = new UploadedFile($file, $info['basename']);
        $name = 'tes.' . $uploaded_file->getClientOriginalExtension();
        // $uploaded_file->move(public_path() . '/upload_media/masalah/satu/', $name);
        // $file_path = $uploaded_file->store('upload_media/masalah');
        // dd($uploaded_file);
        // Storage::disk('public')->store(
        //     'upload_media/masalah/',
        //     $uploaded_file,
        //     $name
        // );
        $path = $uploaded_file->storeAs(
            'avatars',
            $name
        );
        dd($path);
        // Storage::move($url, public_path() . '/upload_media/masalah/satu/', $info['basename']);
    }
    public function index()
    {

        $collection = Lmlj::where('created_at', 'like', date('Y') . '%')
            ->get();
        $col = 'col-6';
        if (auth()->user()->unit->id == 3) {
            $col = 'col-4';
        }
        $data = [
            'title'     => 'Pengajuan LMLJ',
            'slug'      => 'pengajuan-lmlj',
            'kotak_masuk' => $this->getKotakMasuk(),
            'number'    => 0,
            'nolmlj'    => $this->getNoLMLJ($collection),
            'produk'    => Produk::all(),
            'unit'      => Unit::where('id', '!=', auth()->user()->unit->id)->get(),
            'user'      => auth()->user(),
            'ygmengetahui' => auth()->user()->unit->user->where('role_id', 2)->first(),
            'complaint' => Complaint::where('status', 'Proses')->get(),
            'col' => $col
        ];
        return view('lmlj.lembar-masalah-rev1', $data);
    }

    function store(Request $request)
    {
        $status = 0;
        $spv_pengaju_id = null;
        $pesan = 'Lembar masalah berhasil dikirim! Menunggu konfirmasi!';
        if (auth()->user()->role_id == 2) {
            $spv_pengaju_id = auth()->user()->id;
            $status = 1;
            $pesan = 'Lembar masalah berhasil dikirim! Menunggu respon unit tujuan!';
        }
        $unit_pengaju_id = auth()->user()->unit->id;
        $pengaju_id = auth()->user()->id;
        $data_lmlj = [
            'nolmlj' => $request->nolmlj,
            'unit_pengaju_id' => $unit_pengaju_id,
            'pengaju_id' => $pengaju_id,
            'spv_pengaju_id' => $spv_pengaju_id,
            'status' => $status,
            'produk_id' => $request->produk_id
        ];
        Lmlj::create($data_lmlj);
        $lmlj_id = Lmlj::orderBy('id', 'DESC')->first()->id;
        $masalah_id = Masalah::first();
        if ($masalah_id) {
            $masalah_id = Masalah::orderBy('id', 'DESC')->first()->id + 1;
        } else {
            $masalah_id = 1;
        }
        $alphabet = range('A', 'Z');
        if (count($request->unit_tujuan_id) > 1) {
            for ($i = 0; $i < count($request->unit_tujuan_id); $i++) {
                $nolmlj[$request->unit_tujuan_id[$i]] = $request->nolmlj . '-' . $alphabet[$i];
            }
        } else {
            $nolmlj[$request->unit_tujuan_id[0]] = $request->nolmlj;
        }
        foreach ($request->unit_tujuan_id as $item) {
            $data_masalah = [
                'lmlj_id' => $lmlj_id,
                'nolmlj' => $nolmlj[$item],
                'komponen_id' => $request->komponen_id[$item],
                'masalah' => $request->masalah[$item],
                'nilai_tambah' => $request->nilai_tambah[$item],
                'urgensi' => $request->urgensi[$item],
                'unit_tujuan_id' => $item,
                'status' => $status,
                'tanggal_acc' => new Carbon(),
                'keterangan' => $this->getStatusText($status)
            ];
            Masalah::create($data_masalah);
            foreach ($request->detail[$item] as $detail) {
                $data_detail = [
                    'masalah_id' => $masalah_id,
                    'detail' => $detail
                ];
                DetailMasalah::create($data_detail);
            }
            if ($request->hasFile('media_' . $item)) {
                $index = 1;
                foreach ($request->file('media_' . $item) as $item) {
                    $id = sprintf("%02d", $index++);
                    $file_name = $item->getClientOriginalExtension();
                    $name = $request->nolmlj . '-M' . $masalah_id . '-' . $id . '.' . $file_name;
                    $unit = explode("-", $name);
                    $item->move(public_path() . '/storage/upload_media/masalah/' . $unit[0], $name);
                    $data_media = [
                        'masalah_id' => $masalah_id,
                        'file' => $name,
                    ];
                    Media::create($data_media);
                }
            }
            if ($request->nocom > 0) {
                $imagesc = json_decode($request->complaint);
                for ($i = 1; $i < 5; $i++) {
                    $param = 'gambar' . $i;
                    if ($imagesc->{$param}) {
                        // $path = $imagesc->{$param};
                        $path = str_replace(' ', '%20', $imagesc->{$param});
                        $url = "http://28.11.5.6/support-user/monitoring-complaint/images/foto/" . $path;
                        $info = pathinfo($url);
                        $contents = file_get_contents($url);
                        $file = '/opt/lampp/temp/' . $info['basename'];
                        file_put_contents($file, $contents);
                        $uploaded_file = new UploadedFile($file, $info['basename']);
                        $id = sprintf("%02d", $i);
                        $name = $request->nolmlj . '-CRM' . $masalah_id . '-' . $id . '.' . $info['extension'];
                        $unit = explode("-", $name);
                        $path = $uploaded_file->storeAs(
                            'upload_media/masalah/' . $unit[0],
                            $name
                        );
                        $data_media = [
                            'masalah_id' => $masalah_id,
                            'file' => $name,
                        ];
                        Media::create($data_media);
                    }
                }
            }
            $masalah_id++;
        }
        if ($request->tembusan) {
            foreach ($request->tembusan as $item) {
                if ($item) {
                    $data_tembusan = [
                        'lmlj_id' => $lmlj_id,
                        'unit_id' => $item,
                        'status' => 0,
                    ];
                    Tembusan::create($data_tembusan);
                }
            }
        }
        return redirect(url('/dashboard'))->with('status', $pesan);
    }

    public function getKomponenByProdukId($produk_id)
    {
        // $data = Komponen::where('produk_id', $produk_id)->get();
        $data = Komponen::all();
        return response()->json($data);
    }
    public function getUnitTembusan($unit_user, Request $request)
    {
        $data = Unit::where('id', '!=', $unit_user)->whereNotIn('id', $request->unit_id)->get();
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
