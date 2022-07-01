<?php

use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\ProfileController;
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
    Route::post('/login' , [AuthController::class , 'login'])->name("login");
    Route::post('/register' , [AuthController::class , 'register'])->name("register");

    Route::middleware('auth:api')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name("user.profile");
        Route::post('/logout' , [AuthController::class , 'logout'])->name("logout");
    });
});





