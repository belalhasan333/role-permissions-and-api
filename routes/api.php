<?php

namespace App\Http\Controllers\API;

use App\Http\Models\user;
use Illuminate\Support\Facades\Route;

use PHPOpenSourceSaver\JWTAuth\JWTGuard;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TestController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\CategoryController;
// use App\Http\Controllers\WEB\NotificationController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('jwt.auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        // profile
        Route::post('profile', [ProfileController::class, 'me']);
        Route::put('profile', [ProfileController::class, 'updateProfile']);
        Route::put('profile/password', [ProfileController::class, 'changePassword']);
        Route::delete('profile', [ProfileController::class, 'deleteAccount']);

        // categories
        // Route::apiResource('categories', CategoryController::class);
        // products
        // Route::apiResource('products', ProductController::class);
        // notify all users
        // Route::get('notify',NotificationController::class, 'index');
        // Route::post('/notify-subscribers', [NotificationController::class, 'notify'])->name('notify-subscribers');
        Route::get('/v1/notifications', [TestController::class, 'index']);

       Route::post('/v1/notifications/read/{id}', [TestController::class, 'markAsRead']);

        Route::post('/v1/notifications/read-all', [TestController::class, 'markAllAsRead']);

        Route::post('notifications/send', [TestController::class, 'sentTestNotification']);
    });
});
