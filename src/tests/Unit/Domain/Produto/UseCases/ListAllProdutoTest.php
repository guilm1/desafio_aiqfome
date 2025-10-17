<?php

namespace Tests\Unit\Domain\Produto\UseCases;

use App\Domain\Produto\Services\Contracts\ProdutoServiceInterface;
use App\Domain\Produto\UseCases\ListAllProduto;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ListAllProduto::class)]
#[Group('unit')]
class ListAllProdutoTest extends TestCase
{
    /** @var ProdutoServiceInterface&MockInterface */
    private $service;

    private ListAllProduto $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = Mockery::mock(ProdutoServiceInterface::class);
        $this->useCase = new ListAllProduto($this->service);
    }

    #[Test]
    public function retorna_array_de_produtos_quando_service_sucesso(): void
    {
        $payload = [
            ['id' => 1, 'nome' => 'Produto 1'],
            ['id' => 2, 'nome' => 'Produto 2'],
        ];

        $this->service->shouldReceive('listAll')
            ->once()
            ->withNoArgs()
            ->andReturn($payload);

        $retorno = ($this->useCase)();

        $this->assertIsArray($retorno);
        $this->assertCount(2, $retorno);
        $this->assertSame($payload, $retorno);
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

    #[Test]
    public function retorna_array_vazio_quando_service_retornar_array_vazio(): void
    {
        $this->service->shouldReceive('listAll')
            ->once()
            ->withNoArgs()
            ->andReturn([]);

        $retorno = ($this->useCase)();

        $this->assertIsArray($retorno);
        $this->assertCount(0, $retorno);
    }
}
