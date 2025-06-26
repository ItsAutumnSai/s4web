<?php

use Illuminate\Support\Facades\Route;
use Modules\Data\Http\Controllers\DataController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('data', DataController::class)->names('data');
    Route::get('/data/monitoring/{user}', [DataController::class, 'monitoring'])->name('monitoring');
    Route::get('/data/historyiot/{user}', [DataController::class, 'historyiot'])->name('historyiot');
    Route::get('/data/historyyolo/{user}', [DataController::class, 'historyyolo'])->name('historyyolo');
    Route::get('/data/monitoring/{iot_id}', [DataController::class, 'monitoring'])->name('monitoring');

    Route::get('/monitor_iot', [DataController::class, 'getData']);
    Route::get('/monitor_kamera', [DataController::class, 'getKamera']);
    Route::get('/monitor_lidar', [DataController::class, 'getLidar']);
    Route::get('/export-data-user/{iot_id}', [DataController::class, 'exportDataUser'])->name('export.data.user');
    Route::get('/export-data-yolo-user/{iot_id}', [DataController::class, 'exportDataYoloUser'])->name('export.data.yolo.user');
});
