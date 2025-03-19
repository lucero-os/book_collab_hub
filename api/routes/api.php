<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ValidateJwtToken;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware([ValidateJwtToken::class])->group(function () {
    Route::get('/user', [UserController::class, 'getData']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
