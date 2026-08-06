<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\CommunityController;
use App\Models\Membership;
use Symfony\Component\HttpKernel\Profiler\Profile;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login',[LoginController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/membership/apply', [MembershipController::class, 'apply']);

    Route::post('/profile',[ProfileController::class,'profile']);

    Route::post('/profile/update',[ProfileController::class,'update']);
     Route::get('/users', [RegisterController::class, 'index']);

    
    Route::put('/admin/membership/{id}/approve',[MembershipController::class,'approve']);
    
});

Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout']);

Route::middleware(['auth:sanctum'])->get('/admin/memberships', [MembershipController::class, 'index']);


Route::post('/community/join',[CommunityController::class,'join']);