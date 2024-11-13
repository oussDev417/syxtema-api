<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ProfileController;

// Routes publiques
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login');

// Routes protégées
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [ProfileController::class, 'show'])->name('user.show');
    Route::put('/user', [ProfileController::class, 'update'])->name('user.update');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});