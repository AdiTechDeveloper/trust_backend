<?php

use App\Http\Controllers\Admin\CommunityController;
use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\Admin\PoojaController;
use App\Http\Controllers\API\DonationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\API\GalleryController;
use App\Http\Controllers\API\PujaBookingController;
use App\Http\Controllers\API\VideoController;
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

// Donation Endpoints
Route::post('/donations/create-order', [DonationController::class, 'createOrder']);
Route::post('/donations/verify', [DonationController::class, 'verifyPaymentAndDonate']);

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
    Route::get('/admin/memberships', [MembershipController::class, 'index']);
});
Route::get('/poojas', [PoojaController::class, 'publicIndex']);

Route::get('/videos', [VideoController::class, 'index']);

Route::get('/videos/{slug}', [VideoController::class, 'show']);

Route::get('/gallery', [GalleryController::class, 'index']);

Route::get('gallery/{id}', [GalleryController::class, 'show']);

