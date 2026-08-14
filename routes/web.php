<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CommunityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PoojaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VideoController;
use Illuminate\Support\Facades\Route;

// ADMIN PANEL
Route::prefix('admin')->name('admin.')->group(function () {
    // LOGIN (guest only)
    Route::middleware('guest')->group(function () {
        Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    });

    // PROTECTED ADMIN ROUTES
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

        // Community Members
        Route::get('/community-members', [CommunityController::class, 'index'])->name('community-members.index');
        Route::get('/community-members/{communityMember}', [CommunityController::class, 'show'])->name('community-members.show');

        // Poojas (web admin CRUD)
        Route::get('/poojas', [PoojaController::class, 'index'])->name('pooja.index');
        Route::get('/poojas/create', [PoojaController::class, 'create'])->name('pooja.create');
        Route::post('/poojas', [PoojaController::class, 'store'])->name('pooja.store');
        Route::get('/poojas/{id}', [PoojaController::class, 'show'])->name('pooja.show');
        Route::get('/poojas/{id}/edit', [PoojaController::class, 'edit'])->name('pooja.edit');
        Route::put('/poojas/{id}', [PoojaController::class, 'update'])->name('pooja.update');
        Route::delete('/poojas/{id}', [PoojaController::class, 'destroy'])->name('pooja.destroy');

        // video (web admin CRUD)

        Route::get('/videos', [VideoController::class, 'index'])->name('video.index');
        Route::get('/videos/create', [VideoController::class, 'create'])->name('video.create');
        Route::post('/videos', [VideoController::class, 'store'])
            ->name('video.store');
        Route::get('/videos/{id}', [VideoController::class, 'show'])
            ->name('video.show');
        Route::get('/videos/{id}/edit', [VideoController::class, 'edit'])
            ->name('video.edit');
        Route::put('/videos/{id}', [VideoController::class, 'update'])
            ->name('video.update');
        Route::delete('/videos/{id}', [VideoController::class, 'destroy'])
            ->name('video.destroy');
        // Logout
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
