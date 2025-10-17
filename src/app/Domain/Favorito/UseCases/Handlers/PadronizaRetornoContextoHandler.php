<?php

namespace App\Domain\Favorito\UseCases\Handlers;

use App\Domain\Favorito\UseCases\Context\FavoritoContext;
use App\Domain\Favorito\UseCases\Handlers\BaseHandler;

class PadronizaRetornoContextoHandler extends BaseHandler
{
    protected function process(FavoritoContext $contexto): void
    {
        $contexto->retorno = \getProdutoFavorito($contexto);
    }
}
