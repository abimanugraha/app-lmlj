<?php

namespace App\Http\Controllers;

use App\Models\Forward;
use App\Models\Masalah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class SettingController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Setting Profile',
            'slug'  => 'setting',
            'kotak_masuk' => $this->getKotakMasuk(),

        ];


        return view('setting.index', $data);
    }

    function update(Request $request)
    {

        // dd($request->id);
        $validated = $this->validate($request, [
            'picture' => 'mimes:jpeg,png,jpg',
            'nama' => 'required',
            'username' => 'required',
            'password' => 'required',

        ]);

        if ($validated) {
            $user = User::find($request->id);
            // dd($user);
            $user->nama = $request->nama;
            $user->username = $request->username;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            if ($request->hasFile('picture')) {
                $file_name = $request->file('picture')->getClientOriginalExtension();
                $name = $request->id . '.' . $file_name;
                $request->file('picture')->move(public_path() . '/upload_media/user/', $name);
                $user->picture = $name;
            }
            // dd($user);
            $user->save();
        }
        return redirect(url('/setting'))->with('status', 'Profile berhasil diupdate.');
    }
}
