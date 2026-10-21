<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Contoh pengambilan data User.
Route::get('/users', [AuthController::class, 'index']);
Route::get('/users/stats', [AuthController::class, 'stats']);
Route::get('/users/find', [AuthController::class, 'findByEmail']);
Route::get('/users/{id}', [AuthController::class, 'show'])->whereNumber('id');
