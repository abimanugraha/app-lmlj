<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\KomponenRequest;
use App\Models\Komponen;
use Illuminate\Http\Request;

class KomponenController extends Controller
{
    function get($id = null)
    {
        if (isset($id)) {
            $Komponen = Komponen::findOrFail($id);
            return response()->json(['msg' => 'Data retrieved', 'data' => $Komponen], 200);
        } else {
            $Komponens = Komponen::get();
            return response()->json(['msg' => 'Data retrieved', 'data' => $Komponens], 200);
        }
    }

    function store(KomponenRequest $request)
    {
        $Komponen = Komponen::create($request->all());
        return response()->json(['msg' => 'Data created', 'data' => $Komponen], 200);
    }

    function update($id, KomponenRequest $request)
    {
        $Komponen = Komponen::findOrFail($id);
        $Komponen->update($request->all());
        return response()->json(['msg' => 'Data updated', 'data' => $Komponen], 200);
    }

    function destroy($id)
    {
        $Komponen = Komponen::findOrFail($id);
        $Komponen->delete();
        return response()->json(['msg' => 'Data deleted'], 200);
    }
}
