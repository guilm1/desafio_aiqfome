<?php

namespace App\Domain\Produto\Services;

use App\Domain\Produto\Services\Contracts\ProdutoServiceInterface;
use App\Domain\Produto\Integrations\Contracts\ProdutoIntegrationInterface;

class ProdutoService implements ProdutoServiceInterface
{
    public function __construct(private ProdutoIntegrationInterface $integration) {}

    public function listAll(): ?array
    {
        $produtos = $this->integration->listAll();
        return $produtos->data;
    }

    public function getProdutoById(int $id): object
    {
        $produto = $this->integration->getProdutoById($id);
        return $produto;
    }
}
