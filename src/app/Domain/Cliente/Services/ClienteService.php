<?php

namespace App\Domain\Cliente\Services;

use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Domain\Cliente\Services\Contracts\ClienteServiceInterface;
use App\Repositories\Interfaces\ClienteRepositoryInterface;

class ClienteService implements ClienteServiceInterface
{
    public function __construct(private ClienteRepositoryInterface $clientes) {}

    public function listAll($columns = ['nome', 'email', 'uuid']): ?Collection
    {
        return $this->clientes->listAll($columns);
    }

    public function create(array $data): Cliente
    {
        return DB::transaction(function () use ($data) {
            $cliente = new Cliente($data);
            $cliente->save();
            return $cliente;
        });
    }

    public function update(string $uuid, array $data): Cliente
    {
        $cliente = $this->clientes->findByUuid($uuid);
        if (!$cliente) {
            throw new ModelNotFoundException('Cliente não encontrado.');
        }

        $cliente->fill($data);
        $cliente->save();

        return $cliente;
    }

    public function findByUuid(string $uuid): ?Cliente
    {
        $cliente = $this->clientes->findByUuid($uuid);
        if (!$cliente) {
            throw new ModelNotFoundException('Cliente não encontrado.');
        }
        return $cliente;
    }

    public function destroy(string $uuid): bool
    {
        $return = $this->clientes->destroy($uuid);
        if (!$return) {
            throw new ModelNotFoundException('Cliente não encontrado.');
        }

        return (bool) $return;
    }
}
