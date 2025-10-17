<?php

namespace App\Domain\Favorito\UseCases;

use App\Domain\Favorito\UseCases\Context\FavoritoContext;
use App\Domain\Favorito\UseCases\Handlers\ResolveClienteHandler;
use App\Domain\Favorito\UseCases\Handlers\RemoveProdutoFavoritoClienteHandler;
use App\Domain\Favorito\UseCases\Handlers\VerificaExistenciaProdutoFavorito;
use App\Domain\Favorito\UseCases\Handlers\ConsultaApiExternaExistenciaProdutoHandler;

class RemoveFavorito
{
    public function __invoke(FavoritoContext $contexto): FavoritoContext
    {
        $handler = app(ResolveClienteHandler::class);
        $handler->setNext(app(ConsultaApiExternaExistenciaProdutoHandler::class))
            ->setNext(app(VerificaExistenciaProdutoFavorito::class))
            ->setNext(app(RemoveProdutoFavoritoClienteHandler::class));

        $handler->handle($contexto);
        return $contexto;
    }
}
