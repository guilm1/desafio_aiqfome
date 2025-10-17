<?php

namespace App\Domain\Favorito\UseCases\Handlers;

use App\Domain\Favorito\UseCases\Context\FavoritoContext;
use App\Domain\Favorito\UseCases\Handlers\BaseHandler;
use Illuminate\Database\Eloquent\Collection;

class PadronizaRetornoListaContextoHandler extends BaseHandler
{
    protected function process(FavoritoContext $contexto): void
    {
        $contexto->retornoLista = $contexto->produtosValidados;
    }
}
