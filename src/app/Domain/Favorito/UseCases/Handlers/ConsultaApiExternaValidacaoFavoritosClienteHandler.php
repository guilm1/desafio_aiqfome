<?php

namespace App\Domain\Favorito\UseCases\Handlers;

use App\Domain\Favorito\UseCases\Context\FavoritoContext;
use App\Domain\Favorito\UseCases\Handlers\BaseHandler;
use App\Domain\Produto\Integrations\ApiExternaProdutoIntegration;

class ConsultaApiExternaValidacaoFavoritosClienteHandler extends BaseHandler
{
    public function __construct(private ApiExternaProdutoIntegration $apiexternaProduto) {}

    protected function process(FavoritoContext $contexto): void
    {
        $contexto->produtosValidados = $contexto->listaFavoritos
            ->map(function ($favorito) use (&$contexto) {
                $response = $this->apiexternaProduto->getProdutoById($favorito->produto_externo_id);
                $contexto->produto = (object) $response?->data;

                return \getProdutoFavorito($contexto);
            })
            ->filter()
            ->values()
            ->all();
    }
}
