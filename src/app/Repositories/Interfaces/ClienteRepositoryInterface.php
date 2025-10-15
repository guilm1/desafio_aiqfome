<?php

namespace App\Repositories\Interfaces;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Collection;

interface ClienteRepositoryInterface
{
    public function listAll(): ?Collection;
    public function findById(int $id): ?Cliente;
    public function findByUuid(string $uuid): ?Cliente;
    public function findByEmail(string $email): ?Cliente;
    public function destroy(string $uuid): bool;
    public function updateOrCreate(array $data): ?Cliente;
}
