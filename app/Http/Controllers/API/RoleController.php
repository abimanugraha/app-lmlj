<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    function get($id = null)
    {
        if (isset($id)) {
            $role = role::findOrFail($id);
            return response()->json(['msg' => 'Data retrieved', 'data' => $role], 200);
        } else {
            $roles = role::get();
            return response()->json(['msg' => 'Data retrieved', 'data' => $roles], 200);
        }
    }

    function store(RoleRequest $request)
    {
        $role = role::create($request->all());
        return response()->json(['msg' => 'Data created', 'data' => $role], 200);
    }

    function update($id, RoleRequest $request)
    {
        $role = role::findOrFail($id);
        $role->update($request->all());
        return response()->json(['msg' => 'Data updated', 'data' => $role], 200);
    }

    function destroy($id)
    {
        $role = role::findOrFail($id);
        $role->delete();
        return response()->json(['msg' => 'Data deleted'], 200);
    }
}
