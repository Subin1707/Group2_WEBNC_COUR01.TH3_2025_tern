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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommentController;
/*
|--------------------------------------------------------------------------
| 🌍 WEB ROUTES
|--------------------------------------------------------------------------
| Cấu trúc chia 2 phần rõ ràng:
| - Client: xem phim, đặt vé, lịch sử
| - Admin: CRUD quản trị
*/

// 🏠 Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// 👤 Hồ sơ người dùng (cần đăng nhập)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* ============================================================
| 🧑‍🤝‍🧑 CLIENT – chỉ xem hoặc đặt vé
============================================================ */
// Phim
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

// Rạp
Route::get('/theaters', [TheaterController::class, 'index'])->name('theaters.index');
Route::get('/theaters/{theater}', [TheaterController::class, 'show'])->name('theaters.show');

// Suất chiếu
Route::get('/showtimes', [ShowtimeController::class, 'index'])->name('showtimes.index');
Route::get('/showtimes/{showtime}', [ShowtimeController::class, 'show'])->name('showtimes.show');

// Booking (Client)
Route::middleware(['auth'])->group(function () {
    Route::get('/bookings/choose', [BookingController::class, 'chooseShowtime'])->name('bookings.choose');
    Route::get('/bookings/create/{showtime}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index'); // chỉ booking của chính user
    Route::get('/bookings/history', [BookingController::class, 'history'])->name('bookings.history');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show'); // chỉ xem booking của chính user
    Route::middleware(['auth'])->group(function () {
        Route::post('/movies/{movie}/comments', [CommentController::class, 'store'])
            ->name('movies.comments.store');
});
});

/* ============================================================
| 👑 ADMIN – middleware kiểm tra quyền riêng
============================================================ */
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('movies', MovieController::class);
        Route::resource('theaters', TheaterController::class);
        Route::resource('rooms', RoomController::class);
        Route::resource('showtimes', ShowtimeController::class);
        Route::resource('bookings', BookingController::class)->except(['create','store']); // admin không dùng route đặt vé client
        Route::resource('comments', CommentController::class)->only(['index', 'destroy']);
    });

/* ============================================================
| 🧾 Trang tĩnh / Auth
============================================================ */

// Giới thiệu
Route::view('/about', 'about')->name('aboutme');

// 🔐 Đăng nhập / đăng ký
require __DIR__ . '/auth.php';
