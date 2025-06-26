<?php

use Illuminate\Support\Facades\Route;
use Modules\Yolo\Http\Controllers\YoloController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('yolos', YoloController::class)->names('yolo');
});
