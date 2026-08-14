<?php

use App\Http\Controllers\Admin\CommunityController;
use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\Admin\PoojaController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\API\PujaBookingController;
use App\Http\Controllers\Api\videoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::post('/community/join', [CommunityController::class, 'join']);

// Pooja Booking and Slots Checking Endpoints
Route::get('/puja/slots', [PujaBookingController::class, 'getAvailableSlots']);
Route::post('/puja/create-order', [PujaBookingController::class, 'createOrder']);
Route::post('/puja/verify-payment', [PujaBookingController::class, 'verifyPaymentAndBook']);
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

    // Route::middleware('auth:sanctum')->group(function () {
    //     Route::get('/admin/poojas',[PoojaController::class, 'index']);

    //     Route::post('/admin/poojas',[PoojaController::class,'store']);

    //     Route::post('/admin/poojas/{id}',[PoojaController::class,'show']);

    //     Route::post('/admin/poojas/{id}',[PoojaController::class,'update']);

    //     Route::delete('/admin/poojas/{id}',[PoojaController::class,'destroy']);
    // });

    // Admin membership approval
    Route::put(
        '/admin/membership/{id}/approve',
        [MembershipController::class, 'approve']
    );
    Route::get('/admin/memberships', [MembershipController::class, 'index']);
});
Route::get('/poojas', [PoojaController::class, 'publicIndex']);

Route::get('/videos', [videoController::class, 'index']);

Route::get('/videos/{slug}', [videoController::class, 'show']);
