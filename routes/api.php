<?php

use App\Http\Controllers\API\authController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReferralsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// protected routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout', [authController::class, 'logout']);
    Route::get('/user', [authController::class, 'userProfile']);
    Route::post('/admin/referrals', [ReferralsController::class, 'store']);
    Route::get('/admin/referrals', [ReferralsController::class, 'index']);
    Route::get('/user/referrals', [ReferralsController::class, 'userReferrals']);
    Route::put('/admin/referrals/{id}', [ReferralsController::class, 'updateReferrals']);
    Route::post('/admin/referrals/{id}/purchase', [ReferralsController::class, 'simulateUserPurchase']);
    Route::post('/admin/products', [ProductController::class, 'addProduct']);
});

// public routes
Route::post('/register', [authController::class, 'register']);
Route::post('/login', [authController::class, 'login']);
