<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TestController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\CategoryController;

Route::prefix('auth')->group(function () {
    // auth
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    // middleware
    Route::name('api.')->middleware('jwt.auth')->group(function () {
        // auth
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        // profile
        Route::post('profile', [ProfileController::class, 'me']);
        Route::put('profile', [ProfileController::class, 'updateProfile']);
        Route::put('profile/password', [ProfileController::class, 'changePassword']);
        Route::delete('profile', [ProfileController::class, 'deleteAccount']);
        // category
        Route::apiResource('categories', CategoryController::class);
        // product
        Route::apiResource('products', ProductController::class);
        // user
        Route::apiResource('users', UserController::class);
        // notification
        Route::get('v1/notifications', [TestController::class, 'index']);
        Route::post('v1/notifications/read/{id}', [TestController::class, 'markAsRead']);
        Route::post('v1/notifications/read-all', [TestController::class, 'markAllAsRead']);
        // email
        Route::get('email/send', [TestController::class, 'sentTestNotification']);
    });
});
