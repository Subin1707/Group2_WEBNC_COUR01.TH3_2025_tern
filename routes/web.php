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
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// 👤 Hồ sơ người dùng (chỉ khi đã đăng nhập)
Route::middleware('auth')->group(function () {

    // Dashboard người dùng
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    // Hồ sơ cá nhân
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// 🎬 ADMIN: Quản lý hệ thống (chỉ admin được phép)
Route::middleware(['auth', 'admin'])->group(function () {

    // Trang quản trị
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Các module quản lý
    Route::resource('admin/movies', MovieController::class)->names('admin.movies');
    Route::resource('admin/theaters', TheaterController::class)->names('admin.theaters');
    Route::resource('admin/rooms', RoomController::class)->names('admin.rooms');
    Route::resource('admin/showtimes', ShowtimeController::class)->names('admin.showtimes');
    Route::resource('admin/bookings', BookingController::class)->names('admin.bookings');
});


// 🌐 CLIENT: Người dùng xem phim, đặt vé
// Alias các route cơ bản để tránh lỗi “Route not defined”
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

Route::get('/theaters', [TheaterController::class, 'index'])->name('theaters.index');
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/showtimes', [ShowtimeController::class, 'index'])->name('showtimes.index');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');


// 🧭 Trang giới thiệu
Route::view('/about', 'about')->name('aboutme');


// Auth routes (Laravel Breeze / Fortify)
require __DIR__.'/auth.php';
