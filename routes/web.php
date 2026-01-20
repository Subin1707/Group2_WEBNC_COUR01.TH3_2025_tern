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

    // Client dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | ✅ CLIENT BOOKING FLOW (FIX THIẾU ROUTE)
    |--------------------------------------------------------------------------
    */

    // 👉 TRANG CHÍNH "ĐẶT VÉ"
    Route::get('/bookings', [BookingController::class, 'index'])
        ->name('bookings.index');

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

    // Lịch sử booking
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

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/dashboard/revenue', [DashboardController::class, 'revenue'])
            ->name('dashboard.revenue');

        Route::resource('movies', MovieController::class);
        Route::resource('theaters', TheaterController::class);
        Route::resource('rooms', RoomController::class);
        Route::resource('showtimes', ShowtimeController::class);

        Route::resource('bookings', BookingController::class)
            ->except(['create', 'store']);

        Route::resource('comments', CommentController::class)
            ->only(['index', 'destroy']);

        Route::resource('staffs', StaffAccountController::class);
    });

/*
|--------------------------------------------------------------------------
| STAFF ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('bookings', BookingController::class)
            ->except(['create', 'store']);
    });

/*
|--------------------------------------------------------------------------
| AUTH SYSTEM
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| CUSTOMER SUPPORT - USER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('support')
    ->name('support.')
    ->group(function () {

        // Danh sách ticket của user
        Route::get('/', [\App\Http\Controllers\SupportTicketController::class, 'index'])
            ->name('index');

        // Tạo ticket
        Route::get('/create', [\App\Http\Controllers\SupportTicketController::class, 'create'])
            ->name('create');

        Route::post('/', [\App\Http\Controllers\SupportTicketController::class, 'store'])
            ->name('store');

        // Xem chi tiết ticket
        Route::get('/{ticket}', [\App\Http\Controllers\SupportTicketController::class, 'show'])
            ->name('show');

        // User reply
        Route::post('/{ticket}/reply', [\App\Http\Controllers\SupportReplyController::class, 'store'])
            ->name('reply.store');
    });

/*
|--------------------------------------------------------------------------
| CUSTOMER SUPPORT - STAFF
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'staff'])
    ->prefix('staff/support')
    ->name('staff.support.')
    ->group(function () {

        // Danh sách ticket được phân
        Route::get('/', [\App\Http\Controllers\SupportTicketController::class, 'staffIndex'])
            ->name('index');

        // Xem chi tiết
        Route::get('/{ticket}', [\App\Http\Controllers\SupportTicketController::class, 'staffShow'])
            ->name('show');

        // Đổi trạng thái ticket
        Route::patch('/{ticket}/status', [\App\Http\Controllers\SupportTicketController::class, 'updateStatus'])
            ->name('status.update');

        // Reply cho user
        Route::post('/{ticket}/reply', [\App\Http\Controllers\SupportReplyController::class, 'store'])
            ->name('reply.store');
    });

/*
|--------------------------------------------------------------------------
| CUSTOMER SUPPORT - ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin/support')
    ->name('admin.support.')
    ->group(function () {

        // Danh sách toàn bộ ticket
        Route::get('/', [\App\Http\Controllers\SupportTicketController::class, 'adminIndex'])
            ->name('index');

        // Xem chi tiết
        Route::get('/{ticket}', [\App\Http\Controllers\SupportTicketController::class, 'adminShow'])
            ->name('show');

        // Phân ticket cho staff
        Route::patch('/{ticket}/assign', [\App\Http\Controllers\SupportTicketController::class, 'assign'])
            ->name('assign');

        // Đổi trạng thái
        Route::patch('/{ticket}/status', [\App\Http\Controllers\SupportTicketController::class, 'updateStatus'])
            ->name('status.update');

        // Reply
        Route::post('/{ticket}/reply', [\App\Http\Controllers\SupportReplyController::class, 'store'])
            ->name('reply.store');
    });
