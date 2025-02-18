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
use App\Http\Controllers\Api\V1\EventController;
use App\Http\Controllers\Api\V1\ServiceController;
use App\Http\Controllers\Api\V1\CoworkingController;
use App\Http\Controllers\Api\V1\ReservationController;
use App\Http\Controllers\Api\V1\TeamController;

// Routes publiques
Route::post('/v1/login', [LoginController::class, 'login'])->name('login');
Route::post('/v1/register', [RegisterController::class, 'register'])->name('register');

// Routes protégées
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // Routes du profil
    Route::get('/user', [ProfileController::class, 'show']);
    Route::put('/user', [ProfileController::class, 'update']);
    Route::post('/logout', [LoginController::class, 'logout']);

    // Routes des réservations
    Route::apiResource('reservations', 'App\Http\Controllers\Api\V1\ReservationController');
    
    // Autres routes protégées...
});

// Routes publiques avec préfixe v1
Route::prefix('v1')->group(function () {
    Route::apiResource('coworkings', 'App\Http\Controllers\Api\V1\CoworkingController')->only(['index', 'show']);
    // Autres routes publiques...
});

// Routes pour Google Auth
Route::get('/auth/google', [LoginController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::apiResource('newsletter', NewsletterController::class);
Route::prefix('v1')->group(function () {
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/user', [ProfileController::class, 'show'])->name('user.show');
    Route::put('/user', [ProfileController::class, 'update'])->name('user.update');
    Route::apiResource('partners', PartnerController::class)->only(['index', 'show']);
    Route::get('/testimonials', [TestimonialController::class, 'index']);
    Route::get('/testimonials/{id}', [TestimonialController::class, 'show']);
    Route::apiResource('portfolios', PortfolioController::class)->only(['index']);
    Route::get('portfolios/{slug}', [PortfolioController::class, 'showBySlug']);
    Route::apiResource('startups', StartupController::class)->only(['index']);
    Route::get('startups/similar', [StartupController::class, 'getSimilar']);
    Route::get('startups/{slug}', [StartupController::class, 'showBySlug']);
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/news/recent', [NewsController::class, 'getRecent']);
    Route::get('/news/related', [NewsController::class, 'getRelated']);
    Route::get('/news/{slug}', [NewsController::class, 'showBySlug']);
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/related', [EventController::class, 'getRelated']);
    Route::get('/events/{slug}', [EventController::class, 'showBySlug']);
    Route::get('/event-categories', [EventController::class, 'getCategories']);
    Route::get('/countries', [EventController::class, 'getCountries']);
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/related', [ServiceController::class, 'getRelated']);
    Route::get('/services/{slug}', [ServiceController::class, 'showBySlug']);
    Route::get('/service-categories', [ServiceController::class, 'getCategories']);
    Route::get('/service-departements', [ServiceController::class, 'getDepartements']);
    Route::get('/coworkings', [CoworkingController::class, 'index']);
    Route::get('/coworkings/search', [CoworkingController::class, 'search']);
    Route::get('/coworkings/category/{category}', [CoworkingController::class, 'getByCategory']);
    Route::get('/coworkings/{slug}', [CoworkingController::class, 'show']);
    Route::post('/coworkings/{coworking}/check-availability', [CoworkingController::class, 'checkAvailability']);
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show']);
    Route::put('/reservations/{reservation}', [ReservationController::class, 'update']);
    Route::post('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel']);
    Route::get('/teams', [TeamController::class, 'index']);

});

