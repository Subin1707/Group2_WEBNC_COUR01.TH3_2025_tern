<?php
require __DIR__.'/news.php';
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController as ClientNewsController;    
use App\Http\Controllers\NewsController as AdminNewsController;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('news', AdminNewsController::class);
});
Route::prefix('client')->group(function () {
    Route::resource('news', ClientNewsController::class);
});

require __DIR__.'/auth.php';
