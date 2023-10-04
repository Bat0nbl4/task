<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;


Route::middleware('auth:admin')->group(function () {
    Route::resource('books', AdminController::class);
    Route::get('logout', [AdminController::class, 'logout'])->name('logout');
    Route::get('panel/books', [AdminController::class, 'show_panel'])->name('panel');
    Route::get('panel/users', [AdminController::class, 'show_panel_users'])->name('panel_users');
    Route::get('book_form{id?}', [AdminController::class, 'edit'])->name('edit');
    Route::get('register{id?}', [AdminController::class, 'edit_user'])->name('edit_user');
    Route::put('update', [AdminController::class, 'update'])->name('update');
    Route::put('user_update', [AdminController::class, 'user_update'])->name('user_update');
    Route::get('delete_book/{id}', [AdminController::class, 'delete_book'])->name('delete_book');
    Route::get('delete_user/{id}', [AdminController::class, 'delete_user'])->name('delete_user');
});

Route::middleware('guest:admin')->group(function () {
    Route::get('login', [AdminController::class, 'index'])->name('login');
    Route::post('login_check', [AdminController::class, 'login'])->name('login_check');
});
