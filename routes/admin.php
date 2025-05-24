<?php

use App\Http\Controllers\Admin\CategoryController;

Route::group(['prefix' => 'admin', 'middleware' => ['auth'], 'as' => 'admin.'], function () {
    // category
    Route::get('/categories/{category}/duplicate', [CategoryController::class, 'duplicate'])->name('categories.duplicate');
    Route::delete('categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulk-delete');
    Route::resource('categories', CategoryController::class)->except('show');
});
