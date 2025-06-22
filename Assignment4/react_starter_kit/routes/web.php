<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;//Tambahkan 
use App\Http\Controllers\BiodataController;

Route::get('/biodata', [BiodataController::class, 'index'])->name('biodata.index');
Route::get('/biodata/create', [BiodataController::class, 'create'])->name('biodata.create');
Route::post('/biodata', [BiodataController::class, 'store'])->name('biodata.store');
Route::get('/biodata/{id}/edit', [BiodataController::class, 'edit'])->name('biodata.edit');
Route::put('/biodata/{id}', [BiodataController::class, 'update'])->name('biodata.update');
Route::delete('/biodata/{id}', [BiodataController::class, 'destroy'])->name('biodata.destroy');

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
