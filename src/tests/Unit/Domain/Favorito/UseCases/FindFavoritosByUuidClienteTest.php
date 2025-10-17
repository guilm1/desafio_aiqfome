<?php

namespace Tests\Unit\Domain\Favorito\UseCases;

use App\Domain\Favorito\Services\Contracts\FavoritoServiceInterface;
use App\Domain\Favorito\UseCases\Context\FavoritoContext;
use App\Domain\Favorito\UseCases\FindFavoritosByUuidCliente;
use App\Domain\Favorito\UseCases\Handlers\ConsultaApiExternaValidacaoFavoritosClienteHandler;
use App\Domain\Favorito\UseCases\Handlers\ListaFavoritosByClienteHandler;
use App\Domain\Favorito\UseCases\Handlers\PadronizaRetornoListaContextoHandler;
use App\Domain\Favorito\UseCases\Handlers\ResolveClienteHandler;
use App\Repositories\Interfaces\ClienteRepositoryInterface;
use App\Repositories\FavoritoRepository;
use App\Models\Cliente;
use App\Domain\Produto\Integrations\ApiExternaProdutoIntegration;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(FindFavoritosByUuidCliente::class)]
#[Group('unit')]
class FindFavoritosByUuidClienteTest extends TestCase
{
    #[Test]
    public function retorna_lista_padronizada(): void
    {
        /** @var ClienteRepositoryInterface&MockInterface $clienteRepo */
        $clienteRepo = Mockery::mock(ClienteRepositoryInterface::class);
        $uuid = (string) \Illuminate\Support\Str::uuid();
        $cliente = Cliente::factory()->make([
            'uuid'  => $uuid,
            'nome'  => 'Cliente Aiqfome',
            'email' => 'cliente@aiqfome.com.br',
        ]);
        $cliente->id = 20;
        $clienteRepo->shouldReceive('findByUuid')
            ->once()
            ->with($uuid)
            ->andReturn($cliente);

        /** @var ResolveClienteHandler&MockInterface $h1 */
        $h1 = Mockery::mock(ResolveClienteHandler::class, [$clienteRepo])
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        /** @var FavoritoRepository&MockInterface $favRepo */
        $favRepo = Mockery::mock(FavoritoRepository::class);
        /** @var ListaFavoritosByClienteHandler&MockInterface $h2 */
        $h2 = Mockery::mock(ListaFavoritosByClienteHandler::class, [$favRepo])
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();
        $h2->shouldReceive('process')
            ->once()
            ->andReturnUsing(function (FavoritoContext $contexto) {
                $contexto->listaFavoritos = new EloquentCollection([
                    (object)['produto_externo_id' => 1],
                    (object)['produto_externo_id' => 2],
                ]);
                $contexto->produtoExisteListaCliente = true;
            });

        /** @var ApiExternaProdutoIntegration&MockInterface $api */
        $api = Mockery::mock(ApiExternaProdutoIntegration::class);
        /** @var ConsultaApiExternaValidacaoFavoritosClienteHandler&MockInterface $h3 */
        $h3 = Mockery::mock(ConsultaApiExternaValidacaoFavoritosClienteHandler::class, [$api])
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();
        $h3->shouldReceive('process')
            ->once()
            ->andReturnUsing(function (FavoritoContext $contexto) {
                $contexto->produtosValidados = [
                    ['produto_externo_id' => 1, 'nome' => 'Produto 1'],
                    ['produto_externo_id' => 2, 'nome' => 'Produto 2'],
                ];
            });

        $h4 = new PadronizaRetornoListaContextoHandler();

        $this->app->instance(ResolveClienteHandler::class, $h1);
        $this->app->instance(ListaFavoritosByClienteHandler::class, $h2);
        $this->app->instance(ConsultaApiExternaValidacaoFavoritosClienteHandler::class, $h3);
        $this->app->instance(PadronizaRetornoListaContextoHandler::class, $h4);

        $service = Mockery::mock(FavoritoServiceInterface::class);

        $uc = new FindFavoritosByUuidCliente($this->app->make(FavoritoServiceInterface::class) ?: $service);

        $contexto = new FavoritoContext($uuid, null);

        $ret = $uc($contexto);

        $this->assertIsArray($ret);
        $this->assertCount(2, $ret);
        $this->assertEquals(1, $ret[0]['produto_externo_id']);
        $this->assertEquals('Produto 1', $ret[0]['nome']);

        $this->assertIsObject($contexto->cliente);
        $this->assertEquals(20, $contexto->cliente->id);
    }

    #[Test]
    public function lanca_excecao_quando_lista_favoritos_vazia(): void
    {
        $clienteRepo = Mockery::mock(ClienteRepositoryInterface::class);
        $uuid = (string) \Illuminate\Support\Str::uuid();
        $cliente = Cliente::factory()->make([
            'uuid'  => $uuid,
            'nome'  => 'Cliente Aiqfome',
            'email' => 'cliente@aiqfome.com.br',
        ]);
        $cliente->setAttribute('id', 99);

        $clienteRepo->shouldReceive('findByUuid')
            ->once()->with($uuid)->andReturn($cliente);

        $h1 = Mockery::mock(ResolveClienteHandler::class, [$clienteRepo])
            ->makePartial()->shouldAllowMockingProtectedMethods();

        $favRepo = Mockery::mock(FavoritoRepository::class);
        $h2 = Mockery::mock(ListaFavoritosByClienteHandler::class, [$favRepo])
            ->makePartial()->shouldAllowMockingProtectedMethods();
        $h2->shouldReceive('process')
            ->once()
            ->andThrow(new \Exception('Cliente não possui favoritos.'));

        $h3 = Mockery::mock(ConsultaApiExternaValidacaoFavoritosClienteHandler::class, [Mockery::mock(ApiExternaProdutoIntegration::class)])
            ->makePartial()->shouldAllowMockingProtectedMethods();
        $h4 = new PadronizaRetornoListaContextoHandler();

        $this->app->instance(ResolveClienteHandler::class, $h1);
        $this->app->instance(ListaFavoritosByClienteHandler::class, $h2);
        $this->app->instance(ConsultaApiExternaValidacaoFavoritosClienteHandler::class, $h3);
        $this->app->instance(PadronizaRetornoListaContextoHandler::class, $h4);

        $service = Mockery::mock(FavoritoServiceInterface::class);
        $uc = new FindFavoritosByUuidCliente($service);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cliente não possui favoritos.');

        $uc(new FavoritoContext($uuid, null));
    }
}
