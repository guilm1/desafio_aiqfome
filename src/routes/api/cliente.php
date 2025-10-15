<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

Route::prefix('cliente')
    ->middleware(['validate.api.key' /*, 'auth:sanctum', 'policy.access'*/])
    ->group(function () {
        Route::get('/list-all', [ClienteController::class, 'listAll'])
            ->name('list-all');
        Route::get('/{uuid}', [ClienteController::class, 'findByUuid'])
            ->name('find-by-uuid');
        Route::post('/create', [ClienteController::class, 'create'])
            ->name('create');
        Route::put('/update/{uuid}', [ClienteController::class, 'update'])
            ->name('update');
        Route::delete('/remove/{uuid}', [ClienteController::class, 'remove'])
            ->name('remove');
    });
