<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainController::class, 'show_books' ])->name('home');
Route::get('/book/{id}', [MainController::class, 'show_book'])->name('book');
Route::get('/library', [MainController::class, 'library'])->name('library');
Route::get('/user/{user}', [MainController::class, 'show_user'])->name('show_user');

Route::get('/abda', function () { Session::flush(); });

Route::middleware('auth')->group(function () {
    Route::get('/lk/{massage?}{password?}', [MainController::class, 'lk'])->name('lk');
    Route::put('/change_user_data', [AuthController::class, 'change_user_data'])->name('change_user_data');
    Route::put('/change_user_password', [AuthController::class, 'change_user_password'])->name('change_user_password');

    Route::get('/book_form', function () {return view('library/book_form'); })->name('book_form');
    Route::post('/regbook', [MainController::class, 'book_register'])->name('regbook');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showregform'])->name('register');
    Route::post('/register_check', [AuthController::class, 'register'])->name('register_check');

    Route::get('/login', [AuthController::class, 'showloginform'])->name('login');
    Route::post('/login_check', [AuthController::class, 'login'])->name('login_check');
});



