<?php

namespace Tests\Unit\Domain\Favorito\Services;

use App\Domain\Favorito\Services\FavoritoService;
use App\Models\ClienteHasProdutosFavoritos;
use App\Repositories\Interfaces\FavoritoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(FavoritoService::class)]
#[Group('unit')]
class FavoritoServiceTest extends TestCase
{
    /** @var FavoritoRepositoryInterface&MockInterface */
    private $repo;

    private FavoritoService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repo = Mockery::mock(FavoritoRepositoryInterface::class);
        $this->service = new FavoritoService($this->repo);
    }

    #[Test]
    public function addFavorito_retorna_model_quando_cria(): void
    {
        $favorito = new ClienteHasProdutosFavoritos([
            'cliente_id' => 10,
            'produto_externo_id' => 10,
        ]);

        $this->repo->shouldReceive('addFavorito')
            ->once()
            ->with(10, 10)
            ->andReturn($favorito);

        $retorno = $this->service->addFavorito(10, 10);

        $this->assertInstanceOf(ClienteHasProdutosFavoritos::class, $retorno);
        $this->assertEquals(10, $retorno->cliente_id);
        $this->assertEquals(10, $retorno->produto_externo_id);
    }

    #[Test]
    public function removeFavorito_quando_delete_maior_que_zero(): void
    {
        $this->repo->shouldReceive('destroy')
            ->once()
            ->with(10, 55)
            ->andReturn(1);

        $retorno = $this->service->removeFavorito(10, 55);

        $this->assertTrue($retorno);
    }

    #[Test]
    public function removeFavorito_false_quando_delete_zero(): void
    {
        $this->repo->shouldReceive('destroy')
            ->once()
            ->with(10, 999)
            ->andReturn(0);

        $retorno = $this->service->removeFavorito(10, 999);

        $this->assertFalse($retorno);
    }
    
    #[Test]
    public function getAllByIdCliente_retorna_collection_quando_existem_registros(): void
    {
        $collection = new EloquentCollection([
            new ClienteHasProdutosFavoritos(['cliente_id' => 10, 'produto_externo_id' => 1]),
            new ClienteHasProdutosFavoritos(['cliente_id' => 10, 'produto_externo_id' => 2]),
        ]);

        $this->repo->shouldReceive('getAllByIdCliente')
            ->once()
            ->with(10)
            ->andReturn($collection);

        $retorno = $this->service->getAllByIdCliente(10);

        $this->assertInstanceOf(EloquentCollection::class, $retorno);
        $this->assertCount(2, $retorno);
        $this->assertEquals(1, $retorno[0]->produto_externo_id);
    }
}
