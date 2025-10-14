<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ShowtimeController;
use App\Http\Controllers\BookingController;

/*
|--------------------------------------------------------------------------
| 🌍 WEB ROUTES
|--------------------------------------------------------------------------
| Cấu trúc chia 2 phần rõ ràng:
| - Client: truy cập xem phim, đặt vé
| - Admin: CRUD quản trị
*/

// 🏠 Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// 👤 Hồ sơ người dùng (cần đăng nhập)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard'); // Dùng chung
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* ============================================================
| 🧑‍🤝‍🧑 CLIENT (khách hàng) – chỉ xem hoặc đặt vé
============================================================ */

// 🎞️ Phim
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

// 🏢 Rạp
Route::get('/theaters', [TheaterController::class, 'index'])->name('theaters.index');
Route::get('/theaters/{theater}', [TheaterController::class, 'show'])->name('theaters.show');

// 🕒 Suất chiếu
Route::get('/showtimes', [ShowtimeController::class, 'index'])->name('showtimes.index');
Route::get('/showtimes/{showtime}', [ShowtimeController::class, 'show'])->name('showtimes.show');

// 🎟️ Đặt vé (yêu cầu đăng nhập)
Route::middleware(['auth'])->group(function () {
    Route::get('/bookings/choose', [BookingController::class, 'chooseShowtime'])->name('bookings.choose');
    Route::get('/bookings/create/{showtime}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/history', [BookingController::class, 'history'])->name('bookings.history');
});

/* ============================================================
| 👑 ADMIN – middleware kiểm tra quyền riêng
============================================================ */
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard admin cũng dùng chung file dashboard.blade.php
        Route::get('/', fn() => view('dashboard'))->name('dashboard');

        // 🎬 Quản lý CRUD
        Route::resource('movies', MovieController::class);
        Route::resource('theaters', TheaterController::class);
        Route::resource('rooms', RoomController::class);
        Route::resource('showtimes', ShowtimeController::class);
        Route::resource('bookings', BookingController::class);
    });

/* ============================================================
| 🧾 Trang tĩnh / Auth
============================================================ */

// ℹ️ Giới thiệu
Route::view('/about', 'about')->name('aboutme');

// 🔐 Đăng nhập / đăng ký
require __DIR__ . '/auth.php';
