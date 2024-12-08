<?php

use App\Http\Controllers\Api\NewsletterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ProfileController;

// Routes publiques
// Route::post('/user/register', [RegisterController::class, 'register'])->name('register');
// Route::post('/user/login', [LoginController::class, 'login'])->name('login');

// Routes protégées
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [ProfileController::class, 'show'])->name('user.show');
    Route::put('/user', [ProfileController::class, 'update'])->name('user.update');
    // Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Routes pour Google Auth
Route::get('/auth/google', [LoginController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::apiResource('newsletter', NewsletterController::class);
