<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

// Admin Controllers
use App\Http\Controllers\MovieController as AdminMovieController;
use App\Http\Controllers\TheaterController as AdminTheaterController;
use App\Http\Controllers\RoomController as AdminRoomController;
use App\Http\Controllers\ShowtimeController as AdminShowtimeController;
use App\Http\Controllers\BookingController as AdminBookingController;

// Client Controllers
use App\Http\Controllers\MovieController as ClientMovieController;
use App\Http\Controllers\TheaterController as ClientTheaterController;
use App\Http\Controllers\RoomController as ClientRoomController;
use App\Http\Controllers\ShowtimeController as ClientShowtimeController;
use App\Http\Controllers\BookingController as ClientBookingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// 👤 Hồ sơ người dùng (chỉ khi đã login)
Route::middleware('auth')->group(function () {

    // Dashboard người dùng
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    // Trang hồ sơ cá nhân
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🎬 Quản trị hệ thống (Admin)
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

        // Dashboard admin
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Các module quản lý phim, rạp, phòng chiếu, suất chiếu, đặt vé
        Route::resource('movies', AdminMovieController::class);
        Route::resource('theaters', AdminTheaterController::class);
        Route::resource('rooms', AdminRoomController::class);
        Route::resource('showtimes', AdminShowtimeController::class);
        Route::resource('bookings', AdminBookingController::class);
    });

// 🌐 Giao diện người dùng (Client)
Route::prefix('client')
    ->name('client.')
    ->group(function () {

        // Phim
        Route::get('/movies', [ClientMovieController::class, 'index'])->name('movies.index');
        Route::get('/movies/{movie}', [ClientMovieController::class, 'show'])->name('movies.show');

        // Rạp & Phòng chiếu
        Route::get('/theaters', [ClientTheaterController::class, 'index'])->name('theaters.index');
        Route::get('/rooms', [ClientRoomController::class, 'index'])->name('rooms.index');

        // Suất chiếu & Đặt vé
        Route::get('/showtimes', [ClientShowtimeController::class, 'index'])->name('showtimes.index');
        Route::post('/bookings', [ClientBookingController::class, 'store'])->name('bookings.store');
    });

// 🧭 Trang giới thiệu
Route::view('/about', 'about')->name('aboutme');

// Auth routes (Laravel Breeze / Fortify)
require __DIR__.'/auth.php';
