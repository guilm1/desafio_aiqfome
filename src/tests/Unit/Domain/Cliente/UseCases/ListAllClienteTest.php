<?php

namespace Tests\Unit\Domain\Cliente\UseCases;

use App\Domain\Cliente\Services\Contracts\ClienteServiceInterface;
use App\Domain\Cliente\UseCases\ListAllCliente;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ListAllCliente::class)]
#[Group('unit')]
class ListAllClienteTest extends TestCase
{
    /** @var ClienteServiceInterface&MockInterface */
    private $service;

    private ListAllCliente $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = Mockery::mock(ClienteServiceInterface::class);
        $this->useCase = new ListAllCliente($this->service);
    }

    #[Test]
    public function retorna_collection_vinda_do_service(): void
    {
        $uuid1 = (string) \Illuminate\Support\Str::uuid();
        $uuid2 = (string) \Illuminate\Support\Str::uuid();

        $collection = new EloquentCollection([
            new Cliente(['uuid' => $uuid1, 'nome' => 'Cliente Aiqfome 1', 'email' => 'cliente1@aiqfome.com.br']),
            new Cliente(['uuid' => $uuid2, 'nome' => 'Cliente Aiqfome 2', 'email' => 'cliente2@aiqfome.com.br']),
        ]);

        $this->service->shouldReceive('listAll')
            ->once()
            ->withNoArgs()
            ->andReturn($collection);

        $retorno = ($this->useCase)();

        $this->assertInstanceOf(EloquentCollection::class, $retorno);
        $this->assertCount(2, $retorno);
        $this->assertEquals('Cliente Aiqfome 1', $retorno[0]->nome);
    }

    #[Test]
    public function retorna_null_quando_service_retornar_null(): void
    {
        $this->service->shouldReceive('listAll')
            ->once()
            ->withNoArgs()
            ->andReturn(null);

        $retorno = ($this->useCase)();

        $this->assertNull($retorno);
    }
}
