<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;

Route::prefix('produto')
    ->middleware(['validate.api.key', 'auth:sanctum', /*'policy.access'*/])
    ->group(function () {
        Route::get('/list-all', [ProdutoController::class, 'listAll'])
            ->name('list-all');
        Route::get('/{id}', [ProdutoController::class, 'getProdutoById'])
            ->name('id');
    });
