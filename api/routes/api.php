<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ValidateJwtToken;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware([ValidateJwtToken::class])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'getData']);
        Route::post('/addBookPermissions', [UserController::class, 'addBookPermission']);
    });

    Route::prefix('book')->group(function () {
        Route::post('/section', [BookController::class, 'createSection']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});
