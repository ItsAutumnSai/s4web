<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Modules\Dashboard\Http\Controllers\DashboardController;
use Modules\Data\Http\Controllers\DataController;
use Modules\History\Http\Controllers\HistoryController;
use Modules\Yolo\Http\Controllers\YoloController;




Route::middleware(['locale'])->group(function () {

    // Route::get('/', [PageController::class, 'welcome'])->name('welcome');

    Route::get('/', function () {
        // Cek apakah user sudah login
        if (Auth::check()) {
            // Jika sudah login, redirect ke dashboard
            return redirect()->route('dashboard');
        }

        // Jika belum login, redirect ke halaman login
        return redirect()->route('login');
    });

    Route::middleware(['auth'])->group(function () {

        Route::middleware('verified')->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::resource('data', DataController::class)->names('data');
            Route::get('/data/monitoring/{user}', [DataController::class, 'monitoring'])->name('monitoring');
            Route::resource('history', HistoryController::class)->names('history');
            Route::get('/data/historyiot/{user}', [DataController::class, 'historyiot'])->name('historyiot');
            Route::resource('yolo', YoloController::class)->names('yolo');
            Route::get('/yolo', [YoloController::class, 'index']) ->name('yolo.index');
            Route::get('/data/historyyolo/{user}', [DataController::class, 'historyyolo'])->name('historyyolo');



        });

        Route::get('/user', [\App\Http\Controllers\UserController::class, 'index'])->name('user.index')->can('view_user');
        Route::get('/user/create', [\App\Http\Controllers\UserController::class, 'create'])->name('user.create')->can('create_user');
        Route::post('/user', [\App\Http\Controllers\UserController::class, 'store'])->name('user.store')->can('create_user');
        Route::get('/user/{user}', [\App\Http\Controllers\UserController::class, 'show'])->name('user.show')->can('view_user');
        Route::get('/user/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('user.edit')->can('edit_user');
        Route::patch('/user/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('user.update')->can('edit_user');
        Route::delete('/user/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy')->can('delete_user');

        Route::get('/role', [\App\Http\Controllers\RoleController::class, 'index'])->name('role.index')->can('view_role');
        Route::get('/role/create', [\App\Http\Controllers\RoleController::class, 'create'])->name('role.create')->can('create_role');
        Route::post('/role', [\App\Http\Controllers\RoleController::class, 'store'])->name('role.store')->can('create_role');
        Route::get('/role/{role}', [\App\Http\Controllers\RoleController::class, 'show'])->name('role.show')->can('view_role');
        Route::get('/role/{role}/edit', [\App\Http\Controllers\RoleController::class, 'edit'])->name('role.edit')->can('edit_role');
        Route::patch('/role/{role}', [\App\Http\Controllers\RoleController::class, 'update'])->name('role.update')->can('edit_role');
        Route::delete('/role/{role}', [\App\Http\Controllers\RoleController::class, 'destroy'])->name('role.destroy')->can('delete_role');

        Route::as('account.')->prefix('account')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
            Route::get('/change-language', [PageController::class, 'locale'])->name('locale');

            Route::get('/activity-log', [\App\Http\Controllers\ActivityLogController::class, 'index'])->name('log.index');
            Route::delete('/activity-log', [\App\Http\Controllers\ActivityLogController::class, 'destroyBulk'])->name('log.destroy.bulk');
            Route::delete('/activity-log/{log}', [\App\Http\Controllers\ActivityLogController::class, 'destroy'])->name('log.destroy');
        });
    });

    require __DIR__ . '/auth.php';
});
