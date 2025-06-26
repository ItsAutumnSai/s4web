<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\BiodataController;
use Modules\Pendaftaran\Http\Controllers\PendaftaranController;


Route::get('/biodata', [BiodataController::class, 'index'])->name('biodata.index');
Route::get('/biodata/create', [BiodataController::class, 'create'])->name('biodata.create');
Route::post('/biodata', [BiodataController::class, 'store'])->name('biodata.store');
Route::get('/biodata/{id}/edit', [BiodataController::class, 'edit'])->name('biodata.edit');
Route::put('/biodata/{id}', [BiodataController::class, 'update'])->name('biodata.update');
Route::delete('/biodata/{id}', [BiodataController::class, 'destroy'])->name('biodata.destroy');

Route::group([], function() {
    Route::get('pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::get('pendaftaran/data', [PendaftaranController::class, 'getData'])->name('pendaftaran.data');
    Route::post('pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::get('pendaftaran/{id}/edit', [PendaftaranController::class, 'edit'])->name('pendaftaran.edit');
    Route::delete('pendaftaran/{id}', [PendaftaranController::class, 'destroy'])->name('pendaftaran.destroy');
});

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

//Tambahkan 
