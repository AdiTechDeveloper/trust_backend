<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\Admin\CommunityController;

use App\Http\Controllers\Api\ProfileController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [RegisterController::class, 'register']);

Route::post('/login', [LoginController::class, 'login']);


/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', [LoginController::class, 'logout']);

    // Membership
    Route::post('/membership/apply', [MembershipController::class, 'apply']);

    // Member Profile
    Route::get('/profile', [ProfileController::class, 'show']);

    Route::post('/profile/update', [ProfileController::class, 'update']);

    // Users
    Route::get('/users', [RegisterController::class, 'index']);

    // Admin membership approval
    Route::put(
        '/admin/membership/{id}/approve',
        [MembershipController::class, 'approve']
    );
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')
    ->get('/admin/memberships', [MembershipController::class, 'index']);


/*
|--------------------------------------------------------------------------
| Community
|--------------------------------------------------------------------------
*/

Route::post('/community/join', [CommunityController::class, 'join']);