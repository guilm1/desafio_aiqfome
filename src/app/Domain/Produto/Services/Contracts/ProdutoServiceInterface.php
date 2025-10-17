<?php

namespace App\Domain\Produto\Services\Contracts;

interface ProdutoServiceInterface
{
    public function getProdutoById(int $id): object;
    public function listAll(): ?array;
}
