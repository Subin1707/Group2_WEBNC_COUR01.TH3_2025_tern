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


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/revenue', [DashboardController::class, 'revenueChart'])->name('dashboard.revenue');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

Route::get('/theaters', [TheaterController::class, 'index'])->name('theaters.index');
Route::get('/theaters/{theater}', [TheaterController::class, 'show'])->name('theaters.show');

Route::get('/showtimes', [ShowtimeController::class, 'index'])->name('showtimes.index');
Route::get('/showtimes/{showtime}', [ShowtimeController::class, 'show'])->name('showtimes.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/bookings/choose', [BookingController::class, 'chooseShowtime'])->name('bookings.choose');
    Route::get('/bookings/create/{showtime}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index'); 
    Route::get('/bookings/history', [BookingController::class, 'history'])->name('bookings.history');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show'); 
    Route::middleware(['auth'])->group(function () {
        Route::post('/movies/{movie}/comments', [CommentController::class, 'store'])
            ->name('movies.comments.store');
});
});


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


Route::view('/about', 'about')->name('aboutme');

require __DIR__ . '/auth.php';
