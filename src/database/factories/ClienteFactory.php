<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClienteFactory extends Factory
{
    /** @var string */
    protected $model = Cliente::class;

    public function definition(): array
    {
        return [
            'uuid'  => (string) Str::uuid(),
            'nome'  => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function withEmail(string $email): static
    {
        return $this->state(fn() => ['email' => $email]);
    }

    public function withUuid(string $uuid): static
    {
        return $this->state(fn() => ['uuid' => $uuid]);
    }
}
