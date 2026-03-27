<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DokterController;
use App\Http\Controllers\Api\labController;
use App\Http\Controllers\Api\PasienController;
use App\Http\Controllers\Api\JenisController;
use App\Http\Controllers\Api\ParameterController;
use App\Http\Controllers\Api\PermintaanController;
use App\Http\Controllers\Api\HasilController;
use App\Http\Controllers\Api\DistribusiController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\StatistikController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LaporanController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('dokter', DokterController::class)->middleware('auth:sanctum');
Route::apiResource('lab', labController::class)->middleware('auth:sanctum');
Route::apiResource('pasien', PasienController::class)->middleware('auth:sanctum');
Route::apiResource('jenis', JenisController::class)->middleware('auth:sanctum');
Route::apiResource('parameter', ParameterController::class)->middleware('auth:sanctum');
Route::apiResource('permintaan', PermintaanController::class)->middleware('auth:sanctum');
Route::apiResource('hasil', HasilController::class)->middleware('auth:sanctum');
Route::apiResource('distribusi', DistribusiController::class)->middleware('auth:sanctum');
Route::get('/status', [StatusController::class, 'statusPermintaan'])->middleware('auth:sanctum');
Route::get('/statusKritis', [StatusController::class, 'statusKritis'])->middleware('auth:sanctum');
Route::get('/statistik', [StatistikController::class, 'statistikPermintaan'])->middleware('auth:sanctum');
Route::get('/user', [UserController::class, 'getUser'])->middleware('auth:sanctum');
Route::get('/users', [UserController::class, 'index'])->middleware('auth:sanctum');
Route::get('/laporan', [LaporanController::class, 'index'])->middleware('auth:sanctum');

