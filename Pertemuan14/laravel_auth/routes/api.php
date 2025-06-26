<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MahasiswaController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); // Endpoint untuk mendapatkan data user yang sedang login


Route::apiResource('mahasiswa', MahasiswaController::class);
