<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthApiUserController;

Route::prefix('auth')
    ->name('api.auth')
    ->middleware('validate.api.key')
    ->group(function () {
        Route::post('/token', [AuthApiUserController::class, 'login'])
            ->name('token');
    });
