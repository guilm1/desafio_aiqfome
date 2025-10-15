<?php

namespace App\Domain\Cliente\UseCases;

use App\Domain\Cliente\Contracts\ClienteServiceInterface;
use App\Models\Cliente;

class CreateCliente
{
    public function __construct(private ClienteServiceInterface $service) {}

    public function __invoke(array $data): Cliente
    {
        return $this->service->create($data)->makeHidden(['id', 'created_at', 'updated_at']);
    }
}
