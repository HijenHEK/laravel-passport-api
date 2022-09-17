<?php

use App\Http\Controllers\api\v1\AdminAuthController;
use App\Http\Controllers\api\v1\ProfileController;
use App\Http\Controllers\api\v1\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/user')->group(function() {
    Route::post('/login' , [UserAuthController::class , 'login'])->name("user.login");
    Route::post('/register' , [UserAuthController::class , 'register'])->name("user.register");

    Route::middleware('auth:api')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name("user.profile");
        Route::post('/logout' , [UserAuthController::class , 'logout'])->name("user.logout");
        Route::post('/refresh' , [UserAuthController::class , 'refresh'])->name("user.refresh");
    });
});


Route::prefix('/admin')->group(function() {
    Route::post('/login' , [AdminAuthController::class , 'login'])->name("admin.login");
    Route::post('/register' , [AdminAuthController::class , 'register'])->name("admin.register");

    Route::middleware('auth:api')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name("admin.profile");
        Route::post('/logout' , [AdminAuthController::class , 'logout'])->name("admin.logout");
        Route::post('/refresh' , [AdminAuthController::class , 'refresh'])->name("admin.refresh");
    });
});





