<?php

namespace App\Domain\Favorito\Services;


use App\Domain\Favorito\Services\Contracts\FavoritoServiceInterface;
use App\Repositories\Interfaces\FavoritoRepositoryInterface;
use App\Models\ClienteHasProdutosFavoritos;


class FavoritoService implements FavoritoServiceInterface
{
    public function __construct(private FavoritoRepositoryInterface $favoritos) {}

    public function addFavorito(int $clienteId, int $produtoId): ?ClienteHasProdutosFavoritos
    {
        return $this->favoritos->addFavorito($clienteId, $produtoId);
    }

    public function removeFavorito(int $clienteId, int $produtoId): bool
    {
        return $this->favoritos->destroy($clienteId, $produtoId);
    }

    public function getAllByIdCliente(int $id): ?array
    {
        return $this->favoritos->getAllByIdCliente($id);
    }
}
