<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\KotakMasukController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\SettingController;
use App\Models\Jawaban;
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
Route::get('/detail/{masalah:nolmlj}', [DashboardController::class, 'detail'])->middleware('auth');
Route::get('/detail-ajax/{masalah:id}', [DashboardController::class, 'detail'])->middleware('auth');
Route::get('/lmlj-selesai', [DashboardController::class, 'selesai'])->middleware('auth');

Route::get('/pengajuan-lmlj', [PengajuanController::class, 'index'])->middleware('auth');
Route::post('/pengajuan-lmlj', [PengajuanController::class, 'store']);
Route::get('/ajax/komponenbyprodukid/{produk_id}', [PengajuanController::class, 'getKomponenByProdukId']);
Route::get('/ajax/produkbyid/{produk:id}', [PengajuanController::class, 'getProdukById']);
Route::get('/ajax/komponenbyid/{komponen:id}', [PengajuanController::class, 'getKomponenById']);
Route::get('/ajax/unittembusan/{unit_user}', [PengajuanController::class, 'getUnitTembusan']);
// Route::get('/pengajuan-lmlj', function () {
//     return view('LMLJ/lembar-masalah', [
//         'title' => 'Pengajuan LMLJ',
//         'slug'  => 'pengajuan-lmlj'
//     ]);
// })->middleware('auth');
Route::get('/kotak-masuk-lmlj', [KotakMasukController::class, 'index'])->middleware('auth');
Route::get('/lembar-jawaban/{masalah:nolmlj}', [KotakMasukController::class, 'jawab'])->middleware('auth');
Route::post('/lembar-jawaban', [KotakMasukController::class, 'store']);
Route::get('/ajax/konfirmasi/{masalah:id}', [KotakMasukController::class, 'konfirmasimasalah']);
Route::get('/ajax/konfirmasitembusan/{forward:id}', [KotakMasukController::class, 'konfirmasitembusan']);
Route::get('/konfirmasi', [KotakMasukController::class, 'redirect']);
// Route::get('/kotak-masuk-lmlj', function () {
//     return view('LMLJ/kotak-masuk', [
//         'title' => 'Kotak Masuk LMLJ',
//         'slug'  => 'kotak-masuk-lmlj'
//     ]);
// })->middleware('auth');
Route::get('/rekap-progress-lmlj', [RekapController::class, 'index'])->middleware('auth');
Route::get('/lembar-rekap-progress/{masalah:nolmlj}/{id}', [RekapController::class, 'rekap'])->middleware('auth');
Route::post('/lembar-rekap-progress', [RekapController::class, 'store']);
// Route::get('/rekap-progress-lmlj', function () {
//     return view('LMLJ/kotak-rekap', [
//         'title' => 'Rekap Progress LMLJ',
//         'slug'  => 'rekap-progress-lmlj'
//     ]);
// })->middleware('auth');
// Route::get('/lembar-jawaban', function () {
//     return view('LMLJ/lembar-jawaban', [
//         'title' => 'Lembar Jawaban LMLJ',
//         'slug'  => 'kotak-masuk-lmlj',
//     ]);
// })->middleware('auth');
// Route::get('/lembar-rekap-progress', function () {
//     return view('LMLJ/lembar-rekap', [
//         'title' => 'Rekap Progress LMLJ',
//         'slug'  => 'rekap-progress-lmlj',
//     ]);
// })->middleware('auth');
Route::get('/lembar-rekap-progress/{nama}', function ($id = null) {
    return view('LMLJ/lembar-rekap', [
        'title' => 'Rekap Progress LMLJ',
        'slug'  => 'rekap-progress-lmlj',
    ]);
})->middleware('auth');
// Route::get('/detail', function () {
//     return view('LMLJ/detail', [
//         'title' => 'Detail LMLJ',
//         'slug'  => 'dashboard',
//         'lebar_status' => '24%'
//     ]);
// })->middleware('auth');

Route::get('/setting', [SettingController::class, 'index'])->middleware('auth');
Route::post('/edit-profile', [SettingController::class, 'update']);
