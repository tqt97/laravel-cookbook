<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TagController;

Route::group(['prefix' => 'admin', 'middleware' => ['auth'], 'as' => 'admin.'], function () {
    // category
    Route::get('/categories/{category}/duplicate', [CategoryController::class, 'duplicate'])->name('categories.duplicate');
    Route::delete('categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulk-delete');
    Route::resource('categories', CategoryController::class)->except('show');

    // post
    Route::get('/posts/{post}/duplicate', [PostController::class, 'duplicate'])->name('posts.duplicate');
    Route::patch('posts/{post}/restore', [PostController::class, 'restore'])->name('posts.restore')->withTrashed();
    Route::delete('posts/{post}/force-delete', [PostController::class, 'forceDelete'])
        ->name('posts.force-delete')->withTrashed();
    Route::delete('posts/bulk-delete', [PostController::class, 'bulkDelete'])->name('posts.bulk-delete');
    Route::resource('posts', PostController::class)->except('show');

    // tag
    Route::get('/tags/{tag}/duplicate', [TagController::class, 'duplicate'])->name('tags.duplicate');
    Route::delete('tags/bulk-delete', [TagController::class, 'bulkDelete'])->name('tags.bulk-delete');
    Route::resource('tags', TagController::class)->except('show');
});
