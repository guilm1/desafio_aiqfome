<?php

namespace App\Domain\Favorito\UseCases\Handlers;

use App\Domain\Favorito\UseCases\Context\FavoritoContext;
use App\Domain\Favorito\UseCases\Handlers\BaseHandler;
use App\Repositories\FavoritoRepository;
use App\Domain\Favorito\Exceptions\NaoPossuiProdutosException;

class ListaFavoritosByClienteHandler extends BaseHandler
{
    public function __construct(private FavoritoRepository $favoritos) {}

    protected function process(FavoritoContext $contexto): void
    {
        $listaFavoritos = $this->favoritos->getAllByIdCliente($contexto->cliente->id);

        if (count($listaFavoritos) == 0) {
            throw new NaoPossuiProdutosException('Cliente não possui favoritos.');
        }

        $contexto->listaFavoritos = $listaFavoritos;
        $contexto->produtoExisteListaCliente = true;
    }
}
