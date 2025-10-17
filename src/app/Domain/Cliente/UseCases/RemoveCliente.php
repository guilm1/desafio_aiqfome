<?php

namespace App\Domain\Cliente\UseCases;

use App\Domain\Cliente\Services\Contracts\ClienteServiceInterface;

class RemoveCliente
{
    public function __construct(private ClienteServiceInterface $service) {}

    public function __invoke(string $uuid): Bool
    {
        return $this->service->destroy($uuid);
    }
}
