<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ShowtimeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\NewsController as ClientNewsController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;

require __DIR__.'/news.php';

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Trang chủ
Route::get('/', [MovieController::class, 'home'])->name('home');

// 👤 Hồ sơ người dùng
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))
        ->middleware(['verified'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🎬 Quản trị hệ thống (admin)
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {
        // Trang dashboard admin
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Các module quản lý
        Route::resource('movies', MovieController::class);
        Route::resource('theaters', TheaterController::class);
        Route::resource('rooms', RoomController::class);
        Route::resource('showtimes', ShowtimeController::class);
        Route::resource('bookings', BookingController::class);
    });

// 🌐 Giao diện người dùng (client)
Route::prefix('client')
    ->name('client.')
    ->group(function () {
        Route::resource('news', ClientNewsController::class);
    });

// 🧭 Trang giới thiệu
Route::view('/about', 'about')->name('aboutme');

// Auth routes (Laravel Breeze / Fortify)
require __DIR__.'/auth.php';
