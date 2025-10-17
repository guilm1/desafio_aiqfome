<?php

namespace Tests\Unit\Domain\Cliente\UseCases;

use App\Domain\Cliente\Services\Contracts\ClienteServiceInterface;
use App\Domain\Cliente\UseCases\RemoveCliente;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(RemoveCliente::class)]
#[Group('unit')]
class RemoveClienteTest extends TestCase
{
    /** @var ClienteServiceInterface&MockInterface */
    private $service;

    private RemoveCliente $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = Mockery::mock(ClienteServiceInterface::class);
        $this->useCase = new RemoveCliente($this->service);
    }

    #[Test]
    public function retorna_true_quando_service_destroy_sucesso(): void
    {        
        $uuid = (string) \Illuminate\Support\Str::uuid();
        $this->service->shouldReceive('destroy')
            ->once()
            ->with($uuid)
            ->andReturnTrue();

        $ret = ($this->useCase)($uuid);

        $this->assertTrue($ret);
    }

    #[Test]
    public function model_not_found_quando_service_lancar_excecao(): void
    {        
        $uuid = (string) \Illuminate\Support\Str::uuid();
        $this->service->shouldReceive('destroy')
            ->once()
            ->with($uuid)
            ->andThrow(new ModelNotFoundException('Cliente não encontrado.'));

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Cliente não encontrado.');

        ($this->useCase)($uuid);
    }
}
