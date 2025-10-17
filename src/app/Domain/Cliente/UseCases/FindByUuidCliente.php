<?php

namespace App\Domain\Cliente\UseCases;

use App\Domain\Cliente\Services\Contracts\ClienteServiceInterface;
use App\Models\Cliente;

class FindByUuidCliente
{
    public function __construct(private ClienteServiceInterface $service) {}

    public function __invoke(string $uuid): ?Cliente
    {
        $cliente = $this->service->findByUuid($uuid);
        return $cliente?->makeHidden(['id']);
    }
}
