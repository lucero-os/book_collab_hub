<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\ValidateJwtToken;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware([ValidateJwtToken::class])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
