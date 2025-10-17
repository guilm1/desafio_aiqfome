<?php

namespace App\Domain\Produto\UseCases;

use App\Domain\Produto\Services\Contracts\ProdutoServiceInterface;

class GetProdutoById
{
    public function __construct(private ProdutoServiceInterface $service) {}

    public function __invoke(int $id): object
    {
        $produto = $this->service->getProdutoById($id);
        $validaObjetoData = is_object($produto) && property_exists($produto, 'data') && !empty($produto->data);
        if (!$validaObjetoData) {
            throw new \Exception('Produto não encontrado');
        }
        return (object) $produto->data;
    }
}
