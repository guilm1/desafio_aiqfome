<?php

namespace App\Domain\Favorito\UseCases;

use App\Domain\Favorito\UseCases\Context\FavoritoContext;
use App\Domain\Favorito\Services\Contracts\FavoritoServiceInterface;
use App\Domain\Favorito\UseCases\Handlers\ResolveClienteHandler;
use App\Domain\Favorito\UseCases\Handlers\ListaFavoritosByClienteHandler;
use App\Domain\Favorito\UseCases\Handlers\PadronizaRetornoListaContextoHandler;
use App\Domain\Favorito\UseCases\Handlers\ConsultaApiExternaValidacaoFavoritosClienteHandler;

class FindFavoritosByUuidCliente
{
    public function __construct(private FavoritoServiceInterface $service) {}

    public function __invoke(FavoritoContext $contexto)
    {
        $handler = app(ResolveClienteHandler::class);
        $handler->setNext(app(ListaFavoritosByClienteHandler::class))
            ->setNext(app(ConsultaApiExternaValidacaoFavoritosClienteHandler::class))
            ->setNext(app(PadronizaRetornoListaContextoHandler::class));

        $handler->handle($contexto);
        return $contexto?->retornoLista;
    }
}
