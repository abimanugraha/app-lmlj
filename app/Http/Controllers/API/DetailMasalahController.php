<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DetailRequest;
use App\Models\detailmasalah;
use Illuminate\Http\Request;

class DetailMasalahController extends Controller
{
    function get($id = null)
    {
        if (isset($id)) {
            $detailmasalah = detailmasalah::findOrFail($id);
            return response()->json(['msg' => 'Data retrieved', 'data' => $detailmasalah], 200);
        } else {
            $detailmasalahs = detailmasalah::get();
            return response()->json(['msg' => 'Data retrieved', 'data' => $detailmasalahs], 200);
        }
    }

    function store(DetailRequest $request)
    {
        $detailmasalah = detailmasalah::create($request->all());
        return response()->json(['msg' => 'Data created', 'data' => $detailmasalah], 200);
    }

    function update($id, DetailRequest $request)
    {
        $detailmasalah = detailmasalah::findOrFail($id);
        $detailmasalah->update($request->all());
        return response()->json(['msg' => 'Data updated', 'data' => $detailmasalah], 200);
    }

    function destroy($id)
    {
        $detailmasalah = detailmasalah::findOrFail($id);
        $detailmasalah->delete();
        return response()->json(['msg' => 'Data deleted'], 200);
    }
}
