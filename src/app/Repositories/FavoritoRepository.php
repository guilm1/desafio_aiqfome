<?php

namespace App\Repositories;

use App\Repositories\Interfaces\FavoritoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\ClienteHasProdutosFavoritos;
use Illuminate\Support\Facades\DB;

class FavoritoRepository implements FavoritoRepositoryInterface
{

    public function findByIdClienteAndProdutoExternoId(int $clienteId, int $produtoId): ?ClienteHasProdutosFavoritos
    {
        return ClienteHasProdutosFavoritos::query()
            ->where('cliente_id', $clienteId)
            ->where('produto_externo_id', $produtoId)
            ->first();
    }

    public function getAllByIdCliente(int $clienteId): ?Collection
    {
        return ClienteHasProdutosFavoritos::query()
            ->where('cliente_id', $clienteId)
            ->get();
    }

    public function addFavorito(int $clienteId, int $produtoId): ?ClienteHasProdutosFavoritos
    {
        return DB::transaction(function () use ($clienteId, $produtoId) {
            return ClienteHasProdutosFavoritos::create([
                'cliente_id'         => $clienteId,
                'produto_externo_id' => $produtoId,
            ]);
        });
    }

    public function destroy(int $clienteId, int $produtoId): bool
    {
        return DB::transaction(function () use ($clienteId, $produtoId) {
            return ClienteHasProdutosFavoritos::where('cliente_id', $clienteId)
                ->where('produto_externo_id', $produtoId)
                ->delete();
        });
    }
}
