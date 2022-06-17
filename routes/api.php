<?php

use App\Http\Controllers\LembarJawabanController;
use App\Http\Controllers\LembarMasalahController;
use App\Http\Controllers\UserController;
use App\Models\LembarJawaban;
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

//Routing User
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::post('/user/{id}', [UserController::class, 'update']);
Route::post('/user', [UserController::class, 'store']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);

//Routing LM
Route::get('/lm', [LembarMasalahController::class, 'index']);
Route::get('/lm/{id}', [LembarMasalahController::class, 'show']);
Route::post('/lm/{id}', [LembarMasalahController::class, 'update']);
Route::post('/lm', [LembarMasalahController::class, 'store']);
Route::delete('/lm/{id}', [LembarMasalahController::class, 'destroy']);

//Routing LJ
Route::get('/lj', [LembarJawabanController::class, 'index']);
Route::get('/lj/{id}', [LembarJawabanController::class, 'show']);
Route::post('/lj/{id}', [LembarJawabanController::class, 'update']);
Route::post('/lj', [LembarJawabanController::class, 'store']);
Route::delete('/lj/{id}', [LembarJawabanController::class, 'destroy']);
