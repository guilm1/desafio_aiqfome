<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoritoController;

Route::prefix('favorito')
    ->middleware(['validate.api.key', 'auth:sanctum',/* 'policy.access'*/])
    ->group(function () {
        Route::post('/add/{uuid}', [FavoritoController::class, 'addFavorito'])
            ->name('add-favorito');
        Route::delete('/remove/{uuid}/{id}', [FavoritoController::class, 'remove'])
            ->name('remove');
        Route::get('/cliente/{uuid}', [FavoritoController::class, 'findByUuid'])
            ->name('favorito-by uuid cliente');
    });
