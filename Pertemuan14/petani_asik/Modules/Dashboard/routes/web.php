<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\Http\Controllers\DashboardController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('dashboard', DashboardController::class)->names('dashboard');
    Route::get('/datasensor', [DashboardController::class, 'getData']);
    Route::get('/datayolo', [DashboardController::class, 'getDataKamera']);
    Route::get('/datalidar', [DashboardController::class, 'getDataLidar']);
    Route::get('/getRecommendations', [DashboardController::class, 'getDataPrediksi']);
});
