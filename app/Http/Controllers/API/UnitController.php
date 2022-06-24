<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnitRequest;
use App\Models\unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    function get($id = null)
    {
        if (isset($id)) {
            $unit = unit::findOrFail($id);
            return response()->json(['msg' => 'Data retrieved', 'data' => $unit], 200);
        } else {
            $units = unit::get();
            return response()->json(['msg' => 'Data retrieved', 'data' => $units], 200);
        }
    }

    function store(UnitRequest $request)
    {
        $unit = unit::create($request->all());
        return response()->json(['msg' => 'Data created', 'data' => $unit], 200);
    }

    function update($id, UnitRequest $request)
    {
        $unit = unit::findOrFail($id);
        $unit->update($request->all());
        return response()->json(['msg' => 'Data updated', 'data' => $unit], 200);
    }

    function destroy($id)
    {
        $unit = unit::findOrFail($id);
        $unit->delete();
        return response()->json(['msg' => 'Data deleted'], 200);
    }
}
