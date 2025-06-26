<?php

use Illuminate\Support\Facades\Route;
use Modules\Pendaftaran\Http\Controllers\PendaftaranController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('pendaftarans', PendaftaranController::class)->names('pendaftaran');
});
