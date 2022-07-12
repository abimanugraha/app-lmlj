<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // $url = url('api/users');
        // $response = Http::get($url);
        // Http::post($url, $request->all());
        // $response = Http::get("http://localhost:3000/api/user/18");
        // $response = Http::get($url);
        // return json_decode($response->body());
        // return $request->all();
        // return redirect('auth')->with('status', 'User berhasil ditambahkan!');
        // $users = User::where('username', $request->username)->get();
        // return $users;
        $validData = $request->validate([
            'username' => 'required|unique:users|max:10',
            'password' => 'required',
            'nama' => 'required',
        ]);
        $validData['password'] =  Hash::make($request->password);
        $user = user::create($validData);
        return redirect(url('/'))->with('status', 'User berhasil ditambahkan!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(url('dashboard'));
        }

        return back()->with('info', 'Login Gagal! Username atau Password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
