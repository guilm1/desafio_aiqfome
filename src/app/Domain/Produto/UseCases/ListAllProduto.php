<?php

namespace App\Domain\Produto\UseCases;

use App\Domain\Produto\Services\Contracts\ProdutoServiceInterface;

class ListAllProduto
{
    public function __construct(private ProdutoServiceInterface $service) {}

    public function __invoke(): ?array
    {
        $produto = $this->service->listAll();
        return $produto;
    }
}
