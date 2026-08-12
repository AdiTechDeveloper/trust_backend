<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CommunityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// ADMIN PANEL
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        // LOGIN
        Route::middleware('guest')->group(function () {
            Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
            Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

            // PROTECTED ADMIN ROUTES
            Route::middleware('admin')->group(function () {
                Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

                // Users
                Route::get('/users', [UserController::class, 'index'])->name('users.index');

                // Community Members
                Route::get('/community-members', [CommunityController::class, 'index'])->name('community-members.index');
                Route::get('/community-members/{communityMember}', [CommunityController::class, 'show'])->name('community-members.show');

                // Logout
                Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
            });
        });
    });
