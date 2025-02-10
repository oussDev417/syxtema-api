<?php

use App\Http\Controllers\Api\NewsletterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\V1\PartnerController;
use App\Http\Controllers\Api\V1\TestimonialController;
use App\Http\Controllers\Api\V1\PortfolioController;
use App\Http\Controllers\Api\V1\StartupController;
use App\Http\Controllers\Api\V1\NewsController;

// Routes publiques
// Route::post('/register', [RegisterController::class, 'register'])->name('register');
// Route::post('/login', [LoginController::class, 'login'])->name('login');

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
Route::prefix('v1')->group(function () {
    Route::apiResource('partners', PartnerController::class)->only(['index', 'show']);
    Route::get('/testimonials', [TestimonialController::class, 'index']);
    Route::get('/testimonials/{id}', [TestimonialController::class, 'show']);
    Route::apiResource('portfolios', PortfolioController::class)->only(['index']);
    Route::get('portfolios/{slug}', [PortfolioController::class, 'showBySlug']);
    Route::apiResource('startups', StartupController::class)->only(['index']);
    Route::get('startups/similar', [StartupController::class, 'getSimilar']);
    Route::get('startups/{slug}', [StartupController::class, 'showBySlug']);
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/news/related', [NewsController::class, 'getRelated']);
    Route::get('/news/{slug}', [NewsController::class, 'showBySlug']);
});