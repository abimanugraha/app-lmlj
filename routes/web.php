<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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
})->middleware('guest')->name('login');

Route::post('/registrasi', [AuthController::class, 'store']);
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/registrasi', function () {
    return view('auth/registrasi');
})->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/pengajuan-lmlj', function () {
    return view('LMLJ/lembar-masalah', [
        'title' => 'Pengajuan LMLJ',
        'slug'  => 'pengajuan-lmlj'
    ]);
})->middleware('auth');
Route::get('/kotak-masuk-lmlj', function () {
    return view('LMLJ/kotak-masuk', [
        'title' => 'Kotak Masuk LMLJ',
        'slug'  => 'kotak-masuk-lmlj'
    ]);
})->middleware('auth');
Route::get('/rekap-progress-lmlj', function () {
    return view('LMLJ/kotak-rekap', [
        'title' => 'Rekap Progress LMLJ',
        'slug'  => 'rekap-progress-lmlj'
    ]);
})->middleware('auth');
Route::get('/lembar-jawaban', function () {
    return view('LMLJ/lembar-jawaban', [
        'title' => 'Lembar Jawaban LMLJ',
        'slug'  => 'kotak-masuk-lmlj',
    ]);
})->middleware('auth');
Route::get('/lembar-rekap-progress', function () {
    return view('LMLJ/lembar-rekap', [
        'title' => 'Rekap Progress LMLJ',
        'slug'  => 'rekap-progress-lmlj',
    ]);
})->middleware('auth');
Route::get('/detail', function () {
    return view('LMLJ/detail', [
        'title' => 'Detail LMLJ',
        'slug'  => 'dashboard',
        'lebar_status' => '24%'
    ]);
})->middleware('auth');
