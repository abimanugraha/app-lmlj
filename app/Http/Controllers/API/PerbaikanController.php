<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PerbaikanRequest;
use App\Models\perbaikan;
use Illuminate\Http\Request;

class PerbaikanController extends Controller
{
    function get($id = null)
    {
        if (isset($id)) {
            $perbaikan = perbaikan::findOrFail($id);
            return response()->json(['msg' => 'Data retrieved', 'data' => $perbaikan], 200);
        } else {
            $perbaikans = perbaikan::get();
            return response()->json(['msg' => 'Data retrieved', 'data' => $perbaikans], 200);
        }
    }

    function store(PerbaikanRequest $request)
    {
        $perbaikan = perbaikan::create($request->all());
        return response()->json(['msg' => 'Data created', 'data' => $perbaikan], 200);
    }

    function update($id, PerbaikanRequest $request)
    {
        $perbaikan = perbaikan::findOrFail($id);
        $perbaikan->update($request->all());
        return response()->json(['msg' => 'Data updated', 'data' => $perbaikan], 200);
    }

    function destroy($id)
    {
        $perbaikan = perbaikan::findOrFail($id);
        $perbaikan->delete();
        return response()->json(['msg' => 'Data deleted'], 200);
    }
}
