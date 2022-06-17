<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/auth');
});
Route::get('/auth', function () {
    return view('auth/auth');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/form-ajuan', function () {
    return view('LMLJ/formajuan');
});
Route::get('/form-jawaban', function () {
    return view('LMLJ/formjawaban');
});
Route::get('/form-rekap', function () {
    return view('LMLJ/formrekap');
});
Route::get('/status/{id}', function () {
    return view('LMLJ/status');
});
Route::get('/detail/{id}', function () {
    return view('LMLJ/detail');
});
