<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CommunityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PoojaController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ==========================================
// ADMIN PANEL
// ==========================================

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        // ======================================
        // LOGIN
        // ======================================

        Route::middleware('guest')->group(function () {

            Route::get('/login', [
                AuthController::class,
                'showLoginForm',
            ])->name('login');

            Route::post('/login', [
                AuthController::class,
                'login',
            ])->name('login.submit');

        });

        // ======================================
        // PROTECTED ADMIN ROUTES
        // ======================================

        Route::middleware('admin')->group(function () {

            // Dashboard
            Route::get('/dashboard', [
                DashboardController::class,
                'index',
            ])->name('dashboard');

            // Users
            Route::get('/users', [
                UserController::class,
                'index',
            ])->name('users.index');

            // Community Members
            Route::get('/community-members', [
                CommunityController::class,
                'index',
            ])->name('community-members.index');

            Route::get('/community-members/{communityMember}', [
                CommunityController::class,
                'show',
            ])->name('community-members.show');

            Route::get('/pooja', [
                PoojaController::class,
                'index',
            ])->name('pooja.index');

            Route::get('/pooja/create', [
                PoojaController::class,
                'create',
            ])->name('pooja.create');

            Route::post('/pooja', [
                PoojaController::class,
                'store',
            ])->name('pooja.store');

            Route::get('/pooja/{id}', [
                PoojaController::class,
                'show',
            ])->name('pooja.show');

            Route::get('/pooja/{id}/edit', [PoojaController::class, 'edit'])
                ->name('pooja.edit');

            Route::put('/pooja/{id}', [PoojaController::class, 'update'])
                ->name('pooja.update');

            Route::delete('/pooja/{id}', [PoojaController::class, 'destroy'])
                ->name('pooja.destroy');

            // Logout
            Route::post('/logout', [AuthController::class,'logout'])
            ->name('logout');

        });

    });
