<?php

namespace App\Domain\Favorito\UseCases\Handlers;

use App\Domain\Favorito\UseCases\Context\FavoritoContext;
use App\Repositories\Interfaces\ClienteRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Domain\Favorito\UseCases\Handlers\BaseHandler;

class ResolveClienteHandler extends BaseHandler
{
    public function __construct(private ClienteRepositoryInterface $clientes) {}

    protected function process(FavoritoContext $contexto): void
    {
        $cliente = $this->clientes->findByUuid($contexto->uuidCliente);
        if (!$cliente) {
            throw new ModelNotFoundException('Cliente não encontrado.');
        }
        $contexto->cliente = $cliente;
    }
}
