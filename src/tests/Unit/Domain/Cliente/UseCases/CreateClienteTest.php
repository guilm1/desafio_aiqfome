<?php

namespace Tests\Unit\Domain\Cliente\UseCases;

use App\Domain\Cliente\Services\Contracts\ClienteServiceInterface;
use App\Domain\Cliente\UseCases\CreateCliente;
use App\Models\Cliente;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(CreateCliente::class)]
#[Group('unit')]
class CreateClienteTest extends TestCase
{
    /** @var ClienteServiceInterface&MockInterface */
    private $service;

    private CreateCliente $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = Mockery::mock(ClienteServiceInterface::class);
        $this->useCase = new CreateCliente($this->service);
    }

    #[Test]
    public function chama_service_create_e_oculta_campo(): void
    {
        $payload = ['nome' => 'Cliente Aiqfome', 'email' => 'cliente@aiqfome.com.br'];
        $uuid = (string) \Illuminate\Support\Str::uuid();
        $clienteCriado = new Cliente([
            'id'    => 1,
            'uuid'  => $uuid,
            'nome'  => 'Cliente Aiqfome',
            'email' => 'cliente@aiqfome.com.br',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->service->shouldReceive('create')
            ->once()
            ->with($payload)
            ->andReturn($clienteCriado);

        $result = ($this->useCase)($payload);
        
        $this->assertInstanceOf(Cliente::class, $result);
        
        $array = $result->toArray();
        $this->assertArrayNotHasKey('id', $array);
        $this->assertArrayNotHasKey('created_at', $array);
        $this->assertArrayNotHasKey('updated_at', $array);
        
        $this->assertSame('Cliente Aiqfome', $array['nome']);
        $this->assertSame('cliente@aiqfome.com.br', $array['email']);
        $this->assertSame($uuid, $array['uuid']);
    }
}
