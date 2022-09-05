<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\KotakMasukController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\AnalyticController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\KotakKeluarController;
use App\Models\Jawaban;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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
Route::get('/detail/{nolmlj}', [DashboardController::class, 'detail'])->middleware('auth');
Route::get('/detail-ajax/{nolmlj}', [DashboardController::class, 'detail'])->middleware('auth');
Route::get('/lmlj-selesai', [DashboardController::class, 'selesai'])->middleware('auth');

Route::get('/pengajuan-lmlj', [PengajuanController::class, 'index'])->middleware('auth');
Route::post('/pengajuan-lmlj', [PengajuanController::class, 'store']);
Route::get('/ajax/komponenbyprodukid/{produk_id}', [PengajuanController::class, 'getKomponenByProdukId']);
Route::get('/ajax/produkbyid/{produk:id}', [PengajuanController::class, 'getProdukById']);
Route::get('/ajax/komponenbyid/{komponen:id}', [PengajuanController::class, 'getKomponenById']);
Route::get('/ajax/unittembusan/{unit_user}', [PengajuanController::class, 'getUnitTembusan']);

Route::get('/kotak-masuk-lmlj', [KotakMasukController::class, 'index'])->middleware('auth');
Route::get('/lembar-jawaban/{nolmlj}', [KotakMasukController::class, 'jawab'])->middleware('auth');
Route::post('/lembar-jawaban', [KotakMasukController::class, 'store']);
Route::get('/ajax/konfirmasi/{masalah:id}', [KotakMasukController::class, 'konfirmasimasalah']);
Route::get('/ajax/konfirmasitembusan/{tembusan:id}', [KotakMasukController::class, 'konfirmasitembusan']);
Route::get('/ajax/konfirmasi-done/{nolmlj}', [KotakMasukController::class, 'redirect']);
Route::get('/ajax/konfirmasijawaban/{jawaban:id}', [KotakMasukController::class, 'konfirmasijawaban']);
Route::get('/ajax/konfirmasi-jawaban-done/{nolmlj}', [KotakMasukController::class, 'redirectjawaban']);
Route::get('/ajax/editkomponen/{masalah_id}/{komponen_id}', [KotakMasukController::class, 'editkomponen']);
Route::get('ajax/editproduk/{lmlj_id}/{produk_id}', [Controller::class, 'editproduk']);

Route::get('/rekap-progress-lmlj', [RekapController::class, 'index'])->middleware('auth');
Route::get('/lembar-rekap-progress/{masalah:nolmlj}/{id}', [RekapController::class, 'rekap'])->middleware('auth');
Route::post('/lembar-rekap-progress', [RekapController::class, 'store']);

Route::get('/setting', [SettingController::class, 'index'])->middleware('auth');
Route::post('/edit-profile', [SettingController::class, 'update']);

Route::get('/history', [HistoryController::class, 'index'])->middleware('auth');
Route::post('/ajax/history-lmlj', [HistoryController::class, 'getHistoryLmlj']);
Route::get('/history/print-history/{starDate}/{endDate}', [HistoryController::class, 'printHistory']);

Route::get('/analytics', [AnalyticController::class, 'index'])->middleware(['auth', 'role:2']);
Route::get('/ajax/chart-data-lmlj/{year}', [AnalyticController::class, 'getDataChartLmlj']);
Route::get('/ajax/data-statistic-lmlj/{month}', [AnalyticController::class, 'getDataStatistics']);

Route::get('/test', [DashboardController::class, 'createxls']);

Route::get('ajax/test', [PengajuanController::class, 'test']);
Route::get('ajax/getproduk', [Controller::class, 'getProduk']);
Route::get('ajax/getunittembusan/{masalah_id}', [Controller::class, 'getUnitTembusanMasalah']);
Route::get('ajax/edittembusan/{lmlj_id}/{tembusan}', [Controller::class, 'editTembusan']);

Route::get('/kotak-keluar-lmlj', [KotakKeluarController::class, 'index'])->middleware('auth');
Route::get('/ajax/delete-lmlj/{id}', [KotakKeluarController::class, 'deletelmlj'])->middleware('auth');
Route::get('/ajax/delete-lampiran/{id}', [KotakKeluarController::class, 'deletelampiran'])->middleware('auth');
Route::get('/ajax/turnon-lmlj/{id}', [KotakKeluarController::class, 'turnonlmlj'])->middleware('auth');
Route::get('/edit/{nolmlj}', [KotakKeluarController::class, 'edit'])->middleware('auth');
Route::post('/edit-masalah', [KotakKeluarController::class, 'editmasalah'])->middleware('auth');
