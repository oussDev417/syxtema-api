<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Frontend\InstructorCourseController;
use Modules\Course\app\Http\Controllers\CourseController;
use App\Http\Controllers\Admin\CoworkingController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\RecruitmentController;


Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {
    /* Start admin auth route */
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('store-login', [AuthenticatedSessionController::class, 'store'])->name('store-login');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forget-password', [PasswordResetLinkController::class, 'custom_forget_password'])->name('forget-password');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'custom_reset_password_page'])->name('password.reset');
    Route::post('/reset-password-store/{token}', [NewPasswordController::class, 'custom_reset_password_store'])->name('password.reset-store');
    /* End admin auth route */

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard']);
        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

        Route::controller(AdminProfileController::class)->group(function () {
            Route::get('edit-profile', 'edit_profile')->name('edit-profile');
            Route::put('profile-update', 'profile_update')->name('profile-update');
            Route::put('update-password', 'update_password')->name('update-password');
        });

        Route::get('role/assign', [RolesController::class, 'assignRoleView'])->name('role.assign');
        Route::post('role/assign/{id}', [RolesController::class, 'getAdminRoles'])->name('role.assign.admin');
        Route::put('role/assign', [RolesController::class, 'assignRoleUpdate'])->name('role.assign.update');
        Route::resource('/role', RolesController::class);
        Route::resource('/role', RolesController::class);
        Route::get('contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages');
        Route::get('contact-messages/{id}', [ContactMessageController::class, 'show'])->name('contact-messages.show');
        Route::delete('contact-messages/{id}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
        Route::get('courses', [CourseController::class, 'index'])->name('courses.index');

        // Routes pour la gestion des recrutements
        Route::resource('recruitments', RecruitmentController::class);
    });
    Route::resource('admin', AdminController::class)->except('show');
    Route::put('admin-status/{id}', [AdminController::class, 'changeStatus'])->name('admin.status');
    // Settings routes
    Route::get('settings', [SettingController::class, 'settings'])->name('settings');

    // Routes pour la gestion des espaces de coworking
    Route::group(['prefix' => 'coworkings', 'as' => 'coworkings.'], function () {
        Route::get('/', [CoworkingController::class, 'index'])->name('index');
        Route::get('/create', [CoworkingController::class, 'create'])->name('create');
        Route::post('/', [CoworkingController::class, 'store'])->name('store');
        Route::get('/{coworking}/edit', [CoworkingController::class, 'edit'])->name('edit');
        Route::put('/{coworking}', [CoworkingController::class, 'update'])->name('update');
        Route::delete('/{coworking}', [CoworkingController::class, 'destroy'])->name('destroy');
        Route::put('/{coworking}/status', [CoworkingController::class, 'updateStatus'])->name('status.update');
    });

    // Routes pour la gestion des réservations
    Route::group(['prefix' => 'reservations', 'as' => 'reservations.'], function () {
        Route::get('/', [ReservationController::class, 'index'])->name('index');
        Route::get('/pending', [ReservationController::class, 'pending'])->name('pending');
        Route::get('/{reservation}', [ReservationController::class, 'show'])->name('show');
        Route::get('/statistics', [ReservationController::class, 'statistics'])->name('statistics');
        Route::put('/{reservation}/status', [ReservationController::class, 'updateStatus'])->name('status.update');
        Route::delete('/{reservation}', [ReservationController::class, 'destroy'])->name('destroy');
        Route::get('/export', [ReservationController::class, 'export'])->name('export');
    });

    // Routes pour la gestion des messages de contact
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('index');
        Route::get('/{contact}', [ContactController::class, 'show'])->name('show');
        Route::delete('/{contact}', [ContactController::class, 'destroy'])->name('destroy');
    });
});
