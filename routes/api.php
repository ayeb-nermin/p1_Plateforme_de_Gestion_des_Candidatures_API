<?php

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


// TODO: Fix token generation problem later
 // Route::middleware(['token.check', 'users.actions'])->group(function () {
    Route::apiResource('/cvs', \App\Http\Controllers\V1\CvController::class);
    Route::apiResource('/offers', \App\Http\Controllers\V1\OfferController::class);


    // });



