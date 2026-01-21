<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/
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
use App\Http\Controllers\SupportReplyController;
use App\Http\Controllers\SupportTicketController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (HOME)
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
| AUTH ROUTES (USER)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard – THÔNG TIN NGƯỜI DÙNG
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | BOOKING FLOW
    |--------------------------------------------------------------------------
    */
    Route::get('/bookings', [BookingController::class, 'index'])
        ->name('bookings.index');

    Route::get('/bookings/choose', [BookingController::class, 'chooseShowtime'])
        ->name('bookings.choose');

    Route::get('/bookings/create/{showtime}', [BookingController::class, 'create'])
        ->name('bookings.create');

    Route::post('/bookings/payment/preview', [BookingController::class, 'previewPayment'])
        ->name('bookings.payment.preview');

    Route::post('/bookings', [BookingController::class, 'store'])
        ->name('bookings.store');

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

        // ADMIN DASHBOARD (KHÁC USER)
        Route::get('/dashboard', [DashboardController::class, 'admin'])
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

        Route::get('/', [SupportTicketController::class, 'index'])
            ->name('index');

        Route::get('/create', [SupportTicketController::class, 'create'])
            ->name('create');

        Route::post('/', [SupportTicketController::class, 'store'])
            ->name('store');

        Route::get('/{ticket}', [SupportTicketController::class, 'show'])
            ->name('show');

        Route::post('/{ticket}/reply', [SupportReplyController::class, 'store'])
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

        Route::get('/', [SupportTicketController::class, 'staffIndex'])
            ->name('index');

        Route::get('/{ticket}', [SupportTicketController::class, 'staffShow'])
            ->name('show');

        Route::patch('/{ticket}/status', [SupportTicketController::class, 'updateStatus'])
            ->name('status.update');

        Route::post('/{ticket}/reply', [SupportReplyController::class, 'store'])
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

        Route::get('/', [SupportTicketController::class, 'adminIndex'])
            ->name('index');

        Route::get('/{ticket}', [SupportTicketController::class, 'adminShow'])
            ->name('show');

        Route::patch('/{ticket}/assign', [SupportTicketController::class, 'assign'])
            ->name('assign');

        Route::patch('/{ticket}/status', [SupportTicketController::class, 'updateStatus'])
            ->name('status.update');

        Route::post('/{ticket}/reply', [SupportReplyController::class, 'store'])
            ->name('reply.store');
    });
