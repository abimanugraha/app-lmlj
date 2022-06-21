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
    return view('dashboard/dashboard', [
        'title' => 'Dashboard',
        'slug'  => 'dashboard'
    ]);
});
Route::get('/pengajuan-lmlj', function () {
    return view('LMLJ/lembar-masalah', [
        'title' => 'Pengajuan LMLJ',
        'slug'  => 'pengajuan-lmlj'
    ]);
});
Route::get('/kotak-masuk-lmlj', function () {
    return view('LMLJ/kotak-masuk', [
        'title' => 'Kotak Masuk LMLJ',
        'slug'  => 'kotak-masuk-lmlj'
    ]);
});
Route::get('/rekap-progress-lmlj', function () {
    return view('LMLJ/kotak-rekap', [
        'title' => 'Rekap Progress LMLJ',
        'slug'  => 'rekap-progress-lmlj'
    ]);
});
Route::get('/lembar-jawaban', function () {
    return view('LMLJ/lembar-jawaban', [
        'title' => 'Lembar Jawaban LMLJ',
        'slug'  => 'kotak-masuk-lmlj',
    ]);
});
Route::get('/lembar-rekap-progress', function () {
    return view('LMLJ/lembar-rekap', [
        'title' => 'Rekap Progress LMLJ',
        'slug'  => 'rekap-progress-lmlj',
    ]);
});
Route::get('/detail', function () {
    return view('LMLJ/detail', [
        'title' => 'Detail LMLJ',
        'slug'  => 'dashboard',
        'lebar_status' => '24%'
    ]);
});
