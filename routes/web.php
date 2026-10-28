<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Contoh pengambilan data User.
Route::get('/users', [AuthController::class, 'index']);
Route::get('/users/stats', [AuthController::class, 'stats']);
Route::get('/users/find', [AuthController::class, 'findByEmail']);
Route::get('/users/{id}', [AuthController::class, 'show'])->whereNumber('id');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1');

    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:6,1');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [BookController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/my-books', [BookController::class, 'mine'])->name('books.mine');
    Route::post('/books/{book}/borrow', [BookController::class, 'borrow'])->name('books.borrow');
    Route::post('/books/{book}/return', [BookController::class, 'returnBook'])->name('books.return');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
