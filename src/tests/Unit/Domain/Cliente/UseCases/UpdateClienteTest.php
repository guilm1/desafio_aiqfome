<?php

namespace Tests\Unit\Domain\Cliente\UseCases;

use App\Domain\Cliente\Services\Contracts\ClienteServiceInterface;
use App\Domain\Cliente\UseCases\UpdateCliente;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(UpdateCliente::class)]
#[Group('unit')]
class UpdateClienteTest extends TestCase
{
    /** @var ClienteServiceInterface&MockInterface */
    private $service;

    private UpdateCliente $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = Mockery::mock(ClienteServiceInterface::class);
        $this->useCase = new UpdateCliente($this->service);
    }

    #[Test]
    public function retorna_cliente_com_id_oculto(): void
    {        
        $uuid = (string) \Illuminate\Support\Str::uuid();
        $data = ['nome' => 'Cliente Aiqfome New', 'email' => 'new.cliente@aiqfome.com.br'];
        
        $atualizado = new Cliente([
            'id'    => 123,
            'uuid'  => $uuid,
            'nome'  => $data['nome'],
            'email' => $data['email'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->service->shouldReceive('update')
            ->once()
            ->with($uuid, $data)
            ->andReturn($atualizado);

        $result = ($this->useCase)($uuid, $data);

        $this->assertInstanceOf(Cliente::class, $result);

        $arr = $result->toArray();
        $this->assertArrayNotHasKey('id', $arr);
        $this->assertSame($uuid, $arr['uuid']);
        $this->assertSame('Cliente Aiqfome New', $arr['nome']);
        $this->assertSame('new.cliente@aiqfome.com.br', $arr['email']);
    }

    #[Test]
    public function model_not_found_quando_service_lancar_excecao(): void
    {        
        $uuid = (string) \Illuminate\Support\Str::uuid();
        $data = ['nome' => 'Cliente Aiqfome'];

        $this->service->shouldReceive('update')
            ->once()
            ->with($uuid, $data)
            ->andThrow(new ModelNotFoundException('Cliente não encontrado.'));

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Cliente não encontrado.');

        ($this->useCase)($uuid, $data);
    }
}
