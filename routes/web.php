<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WEB\RoleController;
use App\Http\Controllers\WEB\UserController;
use App\Http\Controllers\WEB\ProductController;
use App\Http\Controllers\WEB\ProfileController;
use App\Http\Controllers\WEB\CategoryController;
use App\Http\Controllers\WEB\DashboardController;
use App\Http\Controllers\WEB\SocialAuthController;
use App\Http\Controllers\WEB\NotificationController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/auth/{provider}', [SocialAuthController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback']);
Auth::routes();

Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::post('/profile/image', [ProfileController::class, 'updateImage'])->name('profile.image.update');
    Route::delete('/profile/image/delete', [ProfileController::class, 'deleteImage'])->name('profile.image.delete');

    // Roles
    Route::get('roles/data', [RoleController::class, 'data'])->name('roles.data');
    Route::resource('roles', RoleController::class);

    // Users
    Route::get('users/data', [UserController::class, 'getData'])->name('users.data');
    Route::resource('users', UserController::class);

    // Products
    Route::get('products/data', [ProductController::class, 'data'])->name('products.data');
    Route::resource('products', ProductController::class);

    // Categories
    Route::get('categories/data', [CategoryController::class, 'data'])->name('categories.data');
    Route::resource('categories', CategoryController::class);

    // Notifications
    Route::get('/notification/read/{id}', [NotificationController::class, 'read'])
        ->name('notifications.read');

    Route::get('/notification/mark-all-read', [NotificationController::class, 'markAllRead'])
        ->name('notifications.markAllRead');
});
