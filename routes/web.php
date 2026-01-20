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
use App\Http\Controllers\Admin\StaffAccountController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

Route::get('/theaters', [TheaterController::class, 'index'])->name('theaters.index');
Route::get('/theaters/{theater}', [TheaterController::class, 'show'])->name('theaters.show');

Route::get('/showtimes', [ShowtimeController::class, 'index'])->name('showtimes.index');
Route::get('/showtimes/{showtime}', [ShowtimeController::class, 'show'])->name('showtimes.show');

Route::view('/about', 'about')->name('aboutme');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (CLIENT)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard & profile
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | CLIENT BOOKING FLOW
    |--------------------------------------------------------------------------
    */

    // 1. Chọn suất chiếu
    Route::get('/bookings/choose', [BookingController::class, 'chooseShowtime'])
        ->name('bookings.choose');

    // 2. Chọn ghế
    Route::get('/bookings/create/{showtime}', [BookingController::class, 'create'])
        ->name('bookings.create');

    // 3. Preview thanh toán
    Route::post('/bookings/payment/preview', [BookingController::class, 'previewPayment'])
        ->name('bookings.payment.preview');

    // 4. Thanh toán & tạo booking
    Route::post('/bookings', [BookingController::class, 'store'])
        ->name('bookings.store');

    // 👉 Client chỉ xem booking của mình
    Route::get('/my-bookings', [BookingController::class, 'history'])
        ->name('bookings.history');

    Route::get('/my-bookings/{booking}', [BookingController::class, 'show'])
        ->name('bookings.show');

    /*
    |--------------------------------------------------------------------------
    | COMMENTS
    |--------------------------------------------------------------------------
    */

    Route::post('/movies/{movie}/comments', [CommentController::class, 'store'])
        ->name('movies.comments.store');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('movies', MovieController::class);
        Route::resource('theaters', TheaterController::class);
        Route::resource('rooms', RoomController::class);
        Route::resource('showtimes', ShowtimeController::class);

        // Admin quản lý booking (không tạo)
        Route::resource('bookings', BookingController::class)
            ->except(['create', 'store']);

        Route::resource('comments', CommentController::class)->only(['index', 'destroy']);
        Route::resource('staffs', StaffAccountController::class);
    });

/*
|--------------------------------------------------------------------------
| STAFF ROUTES (QUẢN LÝ BOOKING)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Staff xem / sửa / xóa booking
        Route::resource('bookings', BookingController::class)
            ->except(['create', 'store']);
    });

/*
|--------------------------------------------------------------------------
| AUTH SYSTEM
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
