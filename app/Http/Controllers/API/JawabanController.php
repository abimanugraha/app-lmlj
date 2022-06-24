<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\JawabanRequest;
use App\Models\jawaban;
use Illuminate\Http\Request;

class JawabanController extends Controller
{
    function get($id = null)
    {
        if (isset($id)) {
            $jawaban = jawaban::findOrFail($id);
            return response()->json(['msg' => 'Data retrieved', 'data' => $jawaban], 200);
        } else {
            $jawabans = jawaban::get();
            return response()->json(['msg' => 'Data retrieved', 'data' => $jawabans], 200);
        }
    }

    function store(JawabanRequest $request)
    {
        $jawaban = jawaban::create($request->all());
        return response()->json(['msg' => 'Data created', 'data' => $jawaban], 200);
    }

    function update($id, JawabanRequest $request)
    {
        $jawaban = jawaban::findOrFail($id);
        $jawaban->update($request->all());
        return response()->json(['msg' => 'Data updated', 'data' => $jawaban], 200);
    }

    function destroy($id)
    {
        $jawaban = jawaban::findOrFail($id);
        $jawaban->delete();
        return response()->json(['msg' => 'Data deleted'], 200);
    }
}
