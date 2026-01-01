<?php

namespace App\Http\Controllers\API;

use PHPOpenSourceSaver\JWTAuth\JWTGuard;
use App\Http\Models\user;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\CategoryController;


Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        // profile
        Route::post('profile', [ProfileController::class, 'me']);
        Route::put('profile', [ProfileController::class, 'updateProfile']);
        Route::put('profile/password', [ProfileController::class, 'changePassword']);
        Route::delete('profile', [ProfileController::class, 'deleteAccount']);

        // categories
        Route::resource('categories', CategoryController::class);
        // products
        Route::apiResource('products', ProductController::class); // its go web product controller
    });
});
