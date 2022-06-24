<?php

use App\Http\Controllers\API\DetailMasalahController;
use App\Http\Controllers\API\JawabanController;
use App\Http\Controllers\API\KomponenController;
use App\Http\Controllers\API\MasalahController;
use App\Http\Controllers\API\MediaController;
use App\Http\Controllers\API\PerbaikanController;
use App\Http\Controllers\API\ProdukController;
use App\Http\Controllers\API\roleController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\UnitController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', [UserController::class, 'get']);
Route::get('user/{id}', [UserController::class, 'get']);
Route::post('user', [UserController::class, 'store']);
Route::put('user/{id}', [UserController::class, 'update']);
Route::delete('user/{id}', [UserController::class, 'destroy']);

Route::get('units', [UnitController::class, 'get']);
Route::get('unit/{id}', [UnitController::class, 'get']);
Route::post('unit', [UnitController::class, 'store']);
Route::put('unit/{id}', [UnitController::class, 'update']);
Route::delete('unit/{id}', [UnitController::class, 'destroy']);

Route::get('roles', [RoleController::class, 'get']);
Route::get('role/{id}', [RoleController::class, 'get']);
Route::post('role', [RoleController::class, 'store']);
Route::put('role/{id}', [RoleController::class, 'update']);
Route::delete('role/{id}', [RoleController::class, 'destroy']);


Route::get('produks', [ProdukController::class, 'get']);
Route::get('produk/{id}', [ProdukController::class, 'get']);
Route::post('produk', [ProdukController::class, 'store']);
Route::put('produk/{id}', [ProdukController::class, 'update']);
Route::delete('produk/{id}', [ProdukController::class, 'destroy']);

Route::get('perbaikans', [PerbaikanController::class, 'get']);
Route::get('perbaikan/{id}', [PerbaikanController::class, 'get']);
Route::post('perbaikan', [PerbaikanController::class, 'store']);
Route::put('perbaikan/{id}', [PerbaikanController::class, 'update']);
Route::delete('perbaikan/{id}', [PerbaikanController::class, 'destroy']);

Route::get('medias', [MediaController::class, 'get']);
Route::get('media/{id}', [MediaController::class, 'get']);
Route::post('media', [MediaController::class, 'store']);
Route::put('media/{id}', [MediaController::class, 'update']);
Route::delete('media/{id}', [MediaController::class, 'destroy']);

Route::get('masalahs', [MasalahController::class, 'get']);
Route::get('masalah/{id}', [MasalahController::class, 'get']);
Route::post('masalah', [MasalahController::class, 'store']);
Route::put('masalah/{id}', [MasalahController::class, 'update']);
Route::delete('masalah/{id}', [MasalahController::class, 'destroy']);

Route::get('komponens', [KomponenController::class, 'get']);
Route::get('komponen/{id}', [KomponenController::class, 'get']);
Route::post('komponen', [KomponenController::class, 'store']);
Route::put('komponen/{id}', [KomponenController::class, 'update']);
Route::delete('komponen/{id}', [KomponenController::class, 'destroy']);

Route::get('jawabans', [JawabanController::class, 'get']);
Route::get('jawaban/{id}', [JawabanController::class, 'get']);
Route::post('jawaban', [JawabanController::class, 'store']);
Route::put('jawaban/{id}', [JawabanController::class, 'update']);
Route::delete('jawaban/{id}', [JawabanController::class, 'destroy']);

Route::get('details', [DetailMasalahController::class, 'get']);
Route::get('detail/{id}', [DetailMasalahController::class, 'get']);
Route::post('detail', [DetailMasalahController::class, 'store']);
Route::put('detail/{id}', [DetailMasalahController::class, 'update']);
Route::delete('detail/{id}', [DetailMasalahController::class, 'destroy']);
