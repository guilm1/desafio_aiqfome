<?php

namespace App\Domain\Cliente\UseCases;

use App\Domain\Cliente\Contracts\ClienteServiceInterface;
use App\Models\Cliente;

class ChangeEmailCliente
{
    private ClienteServiceInterface $service;

    public function __construct(ClienteServiceInterface $service) {}

    public function __invoke(string $uuid, string $newEmail): Cliente
    {
        return $this->service->changeEmail($uuid, $newEmail);
    }
}
