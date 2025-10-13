<?php
use illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutmeController;
use App\Http\Controllers\CommentController;

Route::middleware(['auth', 'check.admin'])->group(function () {
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{news}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');
});
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('   news.show');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/aboutme', [AboutmeController::class, 'index'])->name('aboutme');
Route::post('news/{news}/comments', [CommentController::class, 'store'])->name('news.comments.store');
