<?php

namespace Tests\Unit\Domain\Produto\Services;

use App\Domain\Produto\Services\ProdutoService;
use App\Domain\Produto\Integrations\Contracts\ProdutoIntegrationInterface;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ProdutoService::class)]
#[Group('unit')]
class ProdutoServiceTest extends TestCase
{
    /** @var ProdutoIntegrationInterface&MockInterface */
    private $integration;

    private ProdutoService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->integration = Mockery::mock(ProdutoIntegrationInterface::class);
        $this->service     = new ProdutoService($this->integration);
    }

    #[Test]
    public function listAll_retorna_array_de_produtos_quando_integracao_sucesso(): void
    {
        $payload = [
            ['id' => 1, 'nome' => 'Produto 1'],
            ['id' => 2, 'nome' => 'Produto 2'],
        ];

        $this->integration->shouldReceive('listAll')
            ->once()
            ->andReturn($this->padronizaResposta(success: true, status: 200, data: $payload));

        $retorno = $this->service->listAll();

        $this->assertIsArray($retorno);
        $this->assertCount(2, $retorno);
        $this->assertSame($payload, $retorno);
    }

    #[Test]
    public function listAll_retorna_null_quando_integracao_falha(): void
    {
        $this->integration->shouldReceive('listAll')
            ->once()
            ->andReturn($this->padronizaResposta(success: false, status: 500, data: null));

        $retorno = $this->service->listAll();
        $this->assertNull($retorno);
    }

    #[Test]
    public function getProdutoById_retorna_objeto_da_integracao(): void
    {
        $produto = (object) ['id' => 1, 'nome' => 'Produto ID 1'];

        $resp = $this->padronizaResposta(success: true, status: 200, data: $produto);

        $this->integration->shouldReceive('getProdutoById')
            ->once()
            ->with(1)
            ->andReturn($resp);

        $retorno = $this->service->getProdutoById(1);

        $this->assertIsObject($retorno);
        $this->assertTrue($retorno->success);
        $this->assertEquals(200, $retorno->status);
        $this->assertEquals(1, $retorno->data->id);
    }

    #[Test]
    public function getProdutoById_provocando_falha_da_integracao(): void
    {
        $resp = $this->padronizaResposta(success: false, status: 404, data: null, message: 'Not found');

        $this->integration->shouldReceive('getProdutoById')
            ->once()
            ->with(50)
            ->andReturn($resp);

        $ret = $this->service->getProdutoById(50);

        $this->assertIsObject($ret);
        $this->assertFalse($ret->success);
        $this->assertEquals(404, $ret->status);
    }

    private function padronizaResposta(bool $success, ?int $status, $data, ?string $message = null): object
    {
        return (object) array_filter([
            'success' => $success,
            'status'  => $status,
            'data'    => $data,
            'message' => $message,
        ], static fn($v) => $v !== null);
    }
}
