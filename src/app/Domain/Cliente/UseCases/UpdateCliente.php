<?php

namespace App\Domain\Cliente\UseCases;

use App\Domain\Cliente\Contracts\ClienteServiceInterface;
use App\Models\Cliente;

class UpdateCliente
{
    public function __construct(private ClienteServiceInterface $service) {}

    public function __invoke(string $uuid, array $data): Cliente
    {
        return $this->service->update($uuid, $data)->makeHidden(['id']);
    }
}
