<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasalahRequest;
use App\Models\masalah;
use Illuminate\Http\Request;

class MasalahController extends Controller
{
    function get($id = null)
    {
        if (isset($id)) {
            $masalah = masalah::findOrFail($id);
            return response()->json(['msg' => 'Data retrieved', 'data' => $masalah], 200);
        } else {
            $masalahs = masalah::get();
            return response()->json(['msg' => 'Data retrieved', 'data' => $masalahs], 200);
        }
    }

    function store(MasalahRequest $request)
    {
        $masalah = masalah::create($request->all());
        return response()->json(['msg' => 'Data created', 'data' => $masalah], 200);
    }

    function update($id, MasalahRequest $request)
    {
        $masalah = masalah::findOrFail($id);
        $masalah->update($request->all());
        return response()->json(['msg' => 'Data updated', 'data' => $masalah], 200);
    }

    function destroy($id)
    {
        $masalah = masalah::findOrFail($id);
        $masalah->delete();
        return response()->json(['msg' => 'Data deleted'], 200);
    }
}
