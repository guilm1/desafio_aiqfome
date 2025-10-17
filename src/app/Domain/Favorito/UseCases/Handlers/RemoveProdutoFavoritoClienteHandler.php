<?php

namespace App\Domain\Favorito\UseCases\Handlers;

use App\Domain\Favorito\UseCases\Context\FavoritoContext;
use App\Domain\Favorito\UseCases\Handlers\BaseHandler;
use App\Domain\Favorito\Services\FavoritoService;

class RemoveProdutoFavoritoClienteHandler extends BaseHandler
{
    public function __construct(private FavoritoService $favoritos) {}

    protected function process(FavoritoContext $contexto): void
    {
        if ($contexto->produtoExisteListaCliente || !$contexto->produtoExisteValidacaoExterna) {
            return;
        }

        $this->favoritos->removeFavorito(
            $contexto->cliente->id,
            $contexto->produtoId
        );
    }
}
