<?php

namespace App\Domain\Favorito\UseCases\Handlers;

use App\Domain\Favorito\UseCases\Context\FavoritoContext;
use App\Domain\Favorito\UseCases\Handlers\BaseHandler;
use App\Domain\Produto\Integrations\ApiExternaProdutoIntegration;
use App\Domain\Favorito\Exceptions\ProdutoNaoExisteCartelaClienteException;

class ConsultaApiExternaExistenciaProdutoHandler extends BaseHandler
{
    public function __construct(private ApiExternaProdutoIntegration $apiexternaProduto) {}

    protected function process(FavoritoContext $contexto): void
    {
        $exists = $this->apiexternaProduto->getProdutoById($contexto->produtoId);

        if (!$exists?->data) {
            throw new ProdutoNaoExisteCartelaClienteException('Um serviço externo não conseguiu validar a existencia do produto.');
        }

        $contexto->produtoExisteValidacaoExterna = true;
        $contexto->produto = (object) $exists?->data;
    }
}
