<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DokterController;
use App\Http\Controllers\Api\PasienController;
use App\Http\Controllers\Api\JenisController;
use App\Http\Controllers\Api\ParameterController;
use App\Http\Controllers\Api\PermintaanController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('dokter', DokterController::class)->middleware('auth:sanctum');
Route::apiResource('pasien', PasienController::class)->middleware('auth:sanctum');
Route::apiResource('jenis', JenisController::class)->middleware('auth:sanctum');
Route::apiResource('parameter', ParameterController::class)->middleware('auth:sanctum');
Route::apiResource('permintaan', PermintaanController::class)->middleware('auth:sanctum');
