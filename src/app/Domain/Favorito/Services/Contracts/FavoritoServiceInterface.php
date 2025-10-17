<?php

namespace App\Domain\Favorito\Services\Contracts;

use App\Models\ClienteHasProdutosFavoritos;
use Illuminate\Database\Eloquent\Collection;

interface FavoritoServiceInterface
{
    public function addFavorito(int $clienteId, int $produtoId): ?ClienteHasProdutosFavoritos;
    public function removeFavorito(int $clienteId, int $produtoId): bool;
    public function getAllByIdCliente(int $id): ?Collection;
}
