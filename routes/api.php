<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {

    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth:api')->group(function () {

        Route::get('/profile', [AuthController::class, 'profile']);

        Route::post('/refresh', [AuthController::class, 'refresh']);

        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::middleware('auth:api')->group(function () {

    Route::apiResource('orders', OrderController::class);


});
