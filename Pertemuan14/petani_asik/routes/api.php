<?php

use App\Http\Controllers\SensorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/kirim_sensor', [SensorController::class, 'store']);
Route::get('/bacajson/{iot_id}', [SensorController::class, 'getDataLidar']);


