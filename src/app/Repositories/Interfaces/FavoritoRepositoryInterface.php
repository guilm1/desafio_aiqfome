<?php

namespace App\Repositories\Interfaces;

use App\Models\ClienteHasProdutosFavoritos;
use Illuminate\Database\Eloquent\Collection;

interface FavoritoRepositoryInterface
{
    public function addFavorito(int $clienteId, int $produtoId): ?ClienteHasProdutosFavoritos;
    public function getAllByIdCliente(int $clienteId): ?Collection;
    public function findByIdClienteAndProdutoExternoId(int $clienteId, int $produtoId): ?ClienteHasProdutosFavoritos;
    public function destroy(int $clienteId, int $produtoId): bool;
}
