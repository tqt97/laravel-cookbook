<?php

use App\Http\Controllers\Client\Blog\CommentController;
use App\Http\Controllers\Client\Blog\LikeController;
use App\Http\Controllers\Client\Blog\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Show post detail
Route::get('/posts/{post}', PostController::class)->name('posts.show');

// Comment
Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
Route::post('/comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');

// like
Route::post('/like/{type}/{id}', LikeController::class)->name('like.toggle')->middleware('auth');
