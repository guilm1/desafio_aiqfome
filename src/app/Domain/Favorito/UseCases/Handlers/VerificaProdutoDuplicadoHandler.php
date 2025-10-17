<?php

namespace App\Domain\Favorito\UseCases\Handlers;

use App\Domain\Favorito\UseCases\Context\FavoritoContext;
use App\Domain\Favorito\UseCases\Handlers\BaseHandler;
use App\Repositories\FavoritoRepository;

class VerificaProdutoDuplicadoHandler extends BaseHandler
{
    public function __construct(private FavoritoRepository $favoritos) {}

    protected function process(FavoritoContext $contexto): void
    {
        $exists = $this->favoritos->findByIdClienteAndProdutoExternoId($contexto->cliente->id, $contexto->produtoId);

        if ($exists) {
            $contexto->produtoExisteListaCliente = true;
            $contexto->produtoFavorito = $exists;
            throw new \Exception('Produto já está listado nos favoritos do cliente.');
        }
    }
}
