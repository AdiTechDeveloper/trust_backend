<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CommunityController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('welcome');
});

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');


    // Community Members - abhi sirf listing (index) route
     Route::get('/community-members', [CommunityController::class, 'index'])
        ->name('community-members.index');

    Route::get('/community-members/{communityMember}',[CommunityController::class,'show'])
    ->name('community-members.show');
});

