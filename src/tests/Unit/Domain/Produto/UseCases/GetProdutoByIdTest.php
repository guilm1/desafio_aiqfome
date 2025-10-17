<?php

namespace Tests\Unit\Domain\Produto\UseCases;

use App\Domain\Produto\Services\Contracts\ProdutoServiceInterface;
use App\Domain\Produto\UseCases\GetProdutoById;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(GetProdutoById::class)]
#[Group('unit')]
class GetProdutoByIdTest extends TestCase
{
    /** @var ProdutoServiceInterface&MockInterface */
    private $service;

    private GetProdutoById $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = Mockery::mock(ProdutoServiceInterface::class);
        $this->useCase = new GetProdutoById($this->service);
    }

    #[Test]
    public function retorna_objeto_data_quando_sucesso(): void
    {
        $retorno = (object) [
            'success' => true,
            'status'  => 200,
            'data'    => [
                'id'   => 10,
                'nome' => 'Produto Teste',
                'preco'=> 200,
            ],
        ];

        $this->service->shouldReceive('getProdutoById')
            ->once()
            ->with(10)
            ->andReturn($retorno);

        $produto = ($this->useCase)(10);

        $this->assertIsObject($produto);
        $this->assertSame(10, $produto->id);
        $this->assertSame('Produto Teste', $produto->nome);
        $this->assertSame(200, $produto->preco);
    }

    #[Test]
    public function lanca_excecao_quando_data_nulo(): void
    {
        $retorno = (object) [
            'success' => false,
            'status'  => 404,
            'data'    => null,
            'message' => 'Not found',
        ];

        $this->service->shouldReceive('getProdutoById')
            ->once()
            ->with(999)
            ->andReturn($retorno);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Produto não encontrado');

        ($this->useCase)(999);
    }

    #[Test]
    public function lanca_excecao_quando_data_esta_ausente_ou_vazio(): void
    {
        $retornoSemData = (object) [
            'success' => false,
            'status'  => 400,
            'message' => 'Produto não encontrado'
        ];

        $this->service->shouldReceive('getProdutoById')
            ->once()
            ->with(1)
            ->andReturn($retornoSemData);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Produto não encontrado');
        ($this->useCase)(1);
    }
}
