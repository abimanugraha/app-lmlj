<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\MediaRequest;
use App\Models\media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    function get($id = null)
    {
        if (isset($id)) {
            $media = media::findOrFail($id);
            return response()->json(['msg' => 'Data retrieved', 'data' => $media], 200);
        } else {
            $medias = media::get();
            return response()->json(['msg' => 'Data retrieved', 'data' => $medias], 200);
        }
    }

    function store(mediaRequest $request)
    {
        $media = media::create($request->all());
        return response()->json(['msg' => 'Data created', 'data' => $media], 200);
    }

    function update($id, mediaRequest $request)
    {
        $media = media::findOrFail($id);
        $media->update($request->all());
        return response()->json(['msg' => 'Data updated', 'data' => $media], 200);
    }

    function destroy($id)
    {
        $media = media::findOrFail($id);
        $media->delete();
        return response()->json(['msg' => 'Data deleted'], 200);
    }
}
