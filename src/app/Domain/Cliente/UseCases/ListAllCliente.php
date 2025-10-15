<?php

namespace App\Domain\Cliente\UseCases;

use App\Domain\Cliente\Contracts\ClienteServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class ListAllCliente
{
    public function __construct(private ClienteServiceInterface $service) {}

    public function __invoke(): ?Collection
    {
        return $this->service->listAll();
    }
}
