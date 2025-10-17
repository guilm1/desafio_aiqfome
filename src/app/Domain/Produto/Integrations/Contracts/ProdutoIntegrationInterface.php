<?php

namespace App\Domain\Produto\Integrations\Contracts;

interface ProdutoIntegrationInterface
{
    public function listAll(): object;
    public function getProdutoById(int $id): object;
}
