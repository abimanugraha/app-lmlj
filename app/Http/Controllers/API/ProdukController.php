<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProdukRequest;
use App\Models\produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    function get($id = null)
    {
        if (isset($id)) {
            $produk = produk::findOrFail($id);
            return response()->json(['msg' => 'Data retrieved', 'data' => $produk], 200);
        } else {
            $produks = produk::get();
            return response()->json(['msg' => 'Data retrieved', 'data' => $produks], 200);
        }
    }

    function store(ProdukRequest $request)
    {
        $produk = produk::create($request->all());
        return response()->json(['msg' => 'Data created', 'data' => $produk], 200);
    }

    function update($id, ProdukRequest $request)
    {
        $produk = produk::findOrFail($id);
        $produk->update($request->all());
        return response()->json(['msg' => 'Data updated', 'data' => $produk], 200);
    }

    function destroy($id)
    {
        $produk = produk::findOrFail($id);
        $produk->delete();
        return response()->json(['msg' => 'Data deleted'], 200);
    }
}
