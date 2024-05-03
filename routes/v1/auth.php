<?php

use App\Http\Controllers\V1\Auth\ApiUsersLoginController;
use App\Http\Controllers\V1\Auth\AppUsersForgetPasswordController;
use App\Http\Controllers\V1\Auth\AppUsersLoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Allow only request with source param in header and must be valid source
Route::middleware('header.source.check')->group(function () {

    // Routes login & register for api users
    Route::prefix('api-user')->controller(ApiUsersLoginController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
        Route::post('refresh-token', 'refreshToken');
    });

    // Routes that need authentication
    // Route::middleware('auth:api_users_auth')->group(function () {
        // Routes login & register for app users
        Route::prefix('user')->controller(AppUsersLoginController::class)->group(function () {
            Route::post('register', 'register');
            Route::post('login', 'login');
            Route::post('refresh-token', 'refreshToken');
        });

        Route::prefix('user')->controller(AppUsersForgetPasswordController::class)->group(function () {
            Route::post('forget-password', 'forgetPassword');
            Route::get('check-forget-password/{token}', 'checkForgetPasswordToken');
            Route::post('forget-password/{token}', 'editPassword');
        });
    // });
});
