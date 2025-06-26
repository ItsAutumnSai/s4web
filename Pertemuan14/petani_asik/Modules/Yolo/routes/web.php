<?php

use Illuminate\Support\Facades\Route;
use Modules\Yolo\Http\Controllers\YoloController;

Route::middleware(['auth', 'verified'])->group(function () {
    //Route::resource('yolo', YoloController::class)->names('yolo');
    //Route::get('/yolo', [YoloController::class, 'index']) ->name('yolo.index');
    Route::get('/export-data-yolo', [YoloController::class, 'exportDataYolo'])->name('export.data.yolo');
});
