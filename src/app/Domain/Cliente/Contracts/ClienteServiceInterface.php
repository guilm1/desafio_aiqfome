<?php

namespace App\Domain\Cliente\Contracts;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Collection;

interface ClienteServiceInterface
{
    public function create(array $data): Cliente;
    public function update(string $uuid, array $data): Cliente;
    public function changeEmail(string $uuid, string $newEmail): Cliente;
    public function findByUuid(string $uuid): ?Cliente;
    public function destroy(string $uuid): bool;
    public function listAll(): ?Collection;
}
