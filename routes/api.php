<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    Route::get('/profile', [AuthController::class, 'profile']);

    Route::post('/refresh', [AuthController::class, 'refresh']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
