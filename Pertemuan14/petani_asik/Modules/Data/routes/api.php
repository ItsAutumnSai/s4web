<?php

use Illuminate\Support\Facades\Route;
use Modules\Data\Http\Controllers\DataController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('data', DataController::class)->names('data');
});
