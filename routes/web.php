<?php

namespace App\Http\Controllers\WEB;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\API\TestController ;
use App\Http\Controllers\WEB\RoleController;
use App\Http\Controllers\WEB\UserController;
use App\Http\Controllers\WEB\ProductController;
use App\Http\Controllers\WEB\CategoryController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    // notifications
    Route::get('sent-testenrollment', [TestController::class, 'sentTestNotification']);
    //  notifications
    // Route::get('notifications', [APITestController::class, 'index'])->name('notifications.index');
    // Route::post('notifications/send', [APITestController::class, 'sentTestNotification'])->name('notifications.send');
    // Route::delete('notifications/{id}', [APITestController::class, 'destroy'])->name('notifications.destroy');
    Route::resource('notifications', TestController::class);
        Route::get('/notification/read/{id}', [NotificationController::class, 'read'])
        ->name('notifications.read');

    Route::get('/notification/mark-all-read', [NotificationController::class, 'markAllRead'])
        ->name('notifications.markAllRead');

});

