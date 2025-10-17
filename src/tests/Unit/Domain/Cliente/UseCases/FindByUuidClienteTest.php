<?php

namespace Tests\Unit\Domain\Cliente\UseCases;

use App\Domain\Cliente\Services\Contracts\ClienteServiceInterface;
use App\Domain\Cliente\UseCases\FindByUuidCliente;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(FindByUuidCliente::class)]
#[Group('unit')]
class FindByUuidClienteTest extends TestCase
{
    /** @var ClienteServiceInterface&MockInterface */
    private $service;

    private FindByUuidCliente $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = Mockery::mock(ClienteServiceInterface::class);
        $this->useCase = new FindByUuidCliente($this->service);
    }

    #[Test]
    public function retorna_cliente_com_id_oculto_na_serializacao(): void
    {
        $uuid = (string) \Illuminate\Support\Str::uuid();

        $cliente = new Cliente([
            'id'    => 999,
            'uuid'  => $uuid,
            'nome'  => 'Cliente Aiqfome',
            'email' => 'cliente@aiqfome.com.br',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->service->shouldReceive('findByUuid')
            ->once()
            ->with($uuid)
            ->andReturn($cliente);

        $resultado = ($this->useCase)($uuid);

        $this->assertInstanceOf(Cliente::class, $resultado);

        $array = $resultado->toArray();
        $this->assertArrayNotHasKey('id', $array);
        $this->assertSame($uuid, $array['uuid']);
        $this->assertSame('Cliente Aiqfome', $array['nome']);
        $this->assertSame('cliente@aiqfome.com.br', $array['email']);
    }

    #[Test]
    public function model_not_found_quando_service_lanca_excecao(): void
    {
        $uuid = (string) \Illuminate\Support\Str::uuid();
        $this->service->shouldReceive('findByUuid')
            ->once()
            ->with($uuid)
            ->andThrow(new ModelNotFoundException('Cliente não encontrado.'));

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Cliente não encontrado.');

        ($this->useCase)($uuid);
    }
}
