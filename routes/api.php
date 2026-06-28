<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
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

    Route::post('orders/{order}/pay', [PaymentController::class, 'pay']);
    // Route::post('orders/{order}/verify-payment/{transactionId}', [PaymentController::class, 'verify']);

});
