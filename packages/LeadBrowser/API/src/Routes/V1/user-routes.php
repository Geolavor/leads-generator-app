<?php

use Illuminate\Support\Facades\Route;
use LeadBrowser\API\Http\Controllers\V1\User\AccountController;
use LeadBrowser\API\Http\Controllers\V1\User\AuthController;

Route::post('login', [AuthController::class, 'login']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::delete('logout', [AuthController::class, 'logout']);

    Route::get('get', [AccountController::class, 'get']);
    Route::put('update', [AccountController::class, 'update']);

    // Wallet
    Route::get('usage', [AccountController::class, 'getUsage']);
    Route::get('delete-credit-card', [AccountController::class, 'deleteCreditCard']);
});