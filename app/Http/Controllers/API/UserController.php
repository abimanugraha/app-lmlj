<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\user;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function get($id = null)
    {
        if (isset($id)) {
            $user = user::findOrFail($id);
            return response()->json(['msg' => 'Data retrieved', 'data' => $user], 200);
        } else {
            $users = user::get();
            return response()->json(['msg' => 'Data retrieved', 'data' => $users], 200);
        }
    }

    function store(userRequest $request)
    {
        $user = user::create($request->all());
        return response()->json(['msg' => 'Data created', 'data' => $user], 200);
    }

    function update($id, userRequest $request)
    {
        $user = user::findOrFail($id);
        $user->update($request->all());
        return response()->json(['msg' => 'Data updated', 'data' => $user], 200);
    }

    function destroy($id)
    {
        $user = user::findOrFail($id);
        $user->delete();
        return response()->json(['msg' => 'Data deleted'], 200);
    }
}
