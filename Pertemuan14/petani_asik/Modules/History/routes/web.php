<?php

use Illuminate\Support\Facades\Route;
use Modules\History\Http\Controllers\HistoryController;


Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('history', HistoryController::class)->names('history');
    Route::get('/historyiot', [HistoryController::class, 'getHistoryIot']);
    Route::get('/export-data', [HistoryController::class, 'exportData'])->name('export.data');
});

