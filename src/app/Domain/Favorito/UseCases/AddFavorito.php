<?php

namespace App\Domain\Favorito\UseCases;

use App\Domain\Favorito\UseCases\Context\FavoritoContext;
use App\Domain\Favorito\UseCases\Handlers\ResolveClienteHandler;
use App\Domain\Favorito\UseCases\Handlers\VerificaProdutoDuplicadoHandler;
use App\Domain\Favorito\UseCases\Handlers\ConsultaApiExternaExistenciaProdutoHandler;
use App\Domain\Favorito\UseCases\Handlers\PersisteProdutoFavoritoClienteHandler;
use App\Domain\Favorito\UseCases\Handlers\PadronizaRetornoContextoHandler;

class AddFavorito
{
    public function __invoke(FavoritoContext $contexto): FavoritoContext
    {
        $handler = app(ResolveClienteHandler::class);
        $handler->setNext(app(ConsultaApiExternaExistenciaProdutoHandler::class))
            ->setNext(app(VerificaProdutoDuplicadoHandler::class))
            ->setNext(app(PersisteProdutoFavoritoClienteHandler::class))
            ->setNext(app(PadronizaRetornoContextoHandler::class));

        $handler->handle($contexto);
        return $contexto;
    }
}
