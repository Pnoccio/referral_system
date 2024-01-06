<?php

use App\Http\Controllers\API\authController;
use App\Http\Controllers\ReferralsController;
use App\Models\Referrals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// protected routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout', [authController::class, 'logout']);
    Route::get('/user', [authController::class, 'userProfile']);
    Route::post('/admin/referrals', [ReferralsController::class, 'store']);
    Route::get('/admin/referrals', [ReferralsController::class, 'index']);
    Route::get('/user/referrals', [ReferralsController::class, 'userReferrals']);
});

// public routes
Route::post('/register', [authController::class, 'register']);
Route::post('/login', [authController::class, 'login']);
