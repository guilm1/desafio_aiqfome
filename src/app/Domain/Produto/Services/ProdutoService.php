<?php

namespace App\Domain\Produto\Services;

use App\Domain\Produto\Services\Contracts\ProdutoServiceInterface;
use App\Domain\Produto\Integrations\Contracts\ProdutoIntegrationInterface;

class ProdutoService implements ProdutoServiceInterface
{
    public function __construct(private ProdutoIntegrationInterface $integration) {}

    public function listAll(): ?array
    {
        $retorno = $this->integration->listAll();
        if (!($retorno->success ?? false)) {
            return null;
        }
        return is_array($retorno->data ?? null) ? $retorno->data : null;
    }

    public function getProdutoById(int $id): object
    {
        $retorno = $this->integration->getProdutoById($id);
        return $retorno;
    }
}
