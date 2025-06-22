<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\MahasiswaController;

Route::get('/', function () {
    return view('welcome'); // Route langsung Views tanpa controller
});
Route::resource('kontaks', KontakController::class); // routes mengunakan controller yakni akses controller 'KontakController' dengan akses link ‘/kontaks’
Route::resource('mahasiswa', MahasiswaController::class)->except(['show']); // Route ‘/mahasiswa’
Route::get('/mahasiswa/get-data', [MahasiswaController::class, 'getData'])->name('mahasiswa.get-data'); // Route JSON ‘/mahasiswa/get-data’
// routes mengunakan controller yakni akses controller ‘MahasiswaController’
