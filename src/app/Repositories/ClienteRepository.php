<?php

namespace App\Repositories;

use App\Models\Cliente;
use App\Repositories\Interfaces\ClienteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ClienteRepository implements ClienteRepositoryInterface
{
    /**
     * Recupera todos os clientes listados
     *      
     * @return Collection|null
     */
    public function listAll($columns = []): ?Collection
    {
        return Cliente::all($columns);
    }

    /**
     * Encontra um cliente pelo ID.
     * 
     * @param int $id
     * @return Cliente|null
     */
    public function findById(int $id): ?Cliente
    {
        return Cliente::query()->find($id);
    }

    /**
     * Remove um cliente pelo UUID.
     * 
     * @param string $uuid
     * @return bool
     */
    public function destroy(string $uuid): bool
    {
        $cliente = $this->findByUuid($uuid);
        if ($cliente) {
            return (bool) $cliente->delete();
        }
        return false;
    }

    /**
     * Encontra um cliente pelo UUID.
     * 
     * @param string $uuid
     * @return Cliente|null
     */
    public function findByUuid(string $uuid): ?Cliente
    {
        return Cliente::query()->where('uuid', $uuid)->first();
    }

    /**
     * Encontra um cliente pelo email.
     * 
     * @param string $email
     * @return Cliente|null
     */
    public function findByEmail(string $email): ?Cliente
    {
        return Cliente::query()->where('email', $email)->first();
    }

    /**
     * Atualiza ou cria um cliente com base nos dados fornecidos.
     * 
     * @param array $data
     * @return Cliente|null
     */
    public function updateOrCreate(array $data): ?Cliente
    {
        return Cliente::query()->updateOrCreate(
            ['email' => $data['email']],
            $data
        );
    }
}
