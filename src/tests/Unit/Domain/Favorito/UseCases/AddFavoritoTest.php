<?php

namespace Tests\Unit\Domain\Favorito\UseCases;

use App\Domain\Favorito\UseCases\AddFavorito;
use App\Domain\Favorito\UseCases\Context\FavoritoContext;

use App\Domain\Favorito\UseCases\Handlers\ResolveClienteHandler;
use App\Domain\Favorito\UseCases\Handlers\ConsultaApiExternaExistenciaProdutoHandler;
use App\Domain\Favorito\UseCases\Handlers\VerificaProdutoDuplicadoHandler;
use App\Domain\Favorito\UseCases\Handlers\PersisteProdutoFavoritoClienteHandler;
use App\Domain\Favorito\UseCases\Handlers\PadronizaRetornoContextoHandler;

use App\Domain\Favorito\Services\FavoritoService;
use App\Repositories\Interfaces\ClienteRepositoryInterface;
use App\Domain\Produto\Integrations\ApiExternaProdutoIntegration;

use App\Models\Cliente;
use App\Models\ClienteHasProdutosFavoritos;

use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(AddFavorito::class)]
#[Group('unit')]
class AddFavoritoTest extends TestCase
{
    #[Test]
    public function sucesso_persiste_favorito_e_padroniza_retorno(): void
    {
        /** @var ClienteRepositoryInterface&MockInterface $clienteRepo */
        $clienteRepo = Mockery::mock(ClienteRepositoryInterface::class);
        $uuid = (string) \Illuminate\Support\Str::uuid();
        $cliente = Cliente::factory()->make(['uuid' => $uuid, 'nome' => 'Cliente Aiqfome', 'email' => 'cliente@aiqfome.com.br']);
        $cliente->setAttribute('id', 10);

        $clienteRepo->shouldReceive('findByUuid')->once()->with($uuid)->andReturn($cliente);

        /** @var ResolveClienteHandler&MockInterface $h1 */
        $h1 = Mockery::mock(ResolveClienteHandler::class, [$clienteRepo])
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        /** @var ApiExternaProdutoIntegration&MockInterface $api */
        $api = Mockery::mock(ApiExternaProdutoIntegration::class);

        /** @var ConsultaApiExternaExistenciaProdutoHandler&MockInterface $h2 */
        $h2 = Mockery::mock(ConsultaApiExternaExistenciaProdutoHandler::class, [$api])
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();
        $h2->shouldReceive('process')->once()->andReturnUsing(function (FavoritoContext $contexto) {
            $contexto->produtoExisteValidacaoExterna = true;
        });

        /** @var VerificaProdutoDuplicadoHandler&MockInterface $h3 */
        $h3 = Mockery::mock(VerificaProdutoDuplicadoHandler::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();
        $h3->shouldReceive('process')->once()->andReturnUsing(function (FavoritoContext $contexto) {
            $contexto->produtoExisteListaCliente = false;
        });

        /** @var FavoritoService&MockInterface $favoritoService */
        $favoritoService = Mockery::mock(FavoritoService::class)->makePartial();
        $favoritoService->shouldReceive('addFavorito')
            ->once()
            ->with(10, '77')
            ->andReturn(new ClienteHasProdutosFavoritos(['cliente_id' => 10, 'produto_externo_id' => 77]));

        /** @var PersisteProdutoFavoritoClienteHandler&MockInterface $h4 */
        $h4 = Mockery::mock(PersisteProdutoFavoritoClienteHandler::class, [$favoritoService])
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        /** @var PadronizaRetornoContextoHandler&MockInterface $h5 */
        $h5 = Mockery::mock(PadronizaRetornoContextoHandler::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();
        $h5->shouldReceive('process')
            ->once()
            ->andReturnUsing(function (FavoritoContext $contexto) {
                $contexto->retorno = (object) [
                    'cliente_id' => $contexto->cliente->id,
                    'produto_externo_id' => (int) $contexto->produtoId,
                ];
            });

        $this->app->instance(ResolveClienteHandler::class, $h1);
        $this->app->instance(ConsultaApiExternaExistenciaProdutoHandler::class, $h2);
        $this->app->instance(VerificaProdutoDuplicadoHandler::class, $h3);
        $this->app->instance(PersisteProdutoFavoritoClienteHandler::class, $h4);
        $this->app->instance(PadronizaRetornoContextoHandler::class, $h5);

        $uc  = new AddFavorito();
        $contexto = new FavoritoContext($uuid, '77');

        $retorno = $uc($contexto);

        $this->assertSame($contexto, $retorno);
        $this->assertTrue($retorno->produtoExisteValidacaoExterna);
        $this->assertFalse($retorno->produtoExisteListaCliente);
        $this->assertInstanceOf(ClienteHasProdutosFavoritos::class, $retorno->produtoFavorito);
        $this->assertSame(['cliente_id' => 10, 'produto_externo_id' => 77], (array) $retorno->retorno);
    }

    #[Test]
    public function nao_persiste_quando_duplicado(): void
    {
        $clienteRepo = Mockery::mock(ClienteRepositoryInterface::class);
        $uuid2 = (string) \Illuminate\Support\Str::uuid();
        $cliente     = Cliente::factory()->make(['uuid' => $uuid2]);
        $cliente->setAttribute('id', 33);
        $clienteRepo->shouldReceive('findByUuid')->andReturn($cliente);
        $h1 = Mockery::mock(ResolveClienteHandler::class, [$clienteRepo])->makePartial()->shouldAllowMockingProtectedMethods();

        $api = Mockery::mock(ApiExternaProdutoIntegration::class);
        $h2  = Mockery::mock(ConsultaApiExternaExistenciaProdutoHandler::class, [$api])->makePartial()->shouldAllowMockingProtectedMethods();
        $h2->shouldReceive('process')->once()->andReturnUsing(fn(FavoritoContext $c) => $c->produtoExisteValidacaoExterna = true);

        $h3  = Mockery::mock(VerificaProdutoDuplicadoHandler::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $h3->shouldReceive('process')->once()->andReturnUsing(fn(FavoritoContext $c) => $c->produtoExisteListaCliente = true);

        $favoritoService = Mockery::mock(FavoritoService::class)->makePartial();
        $favoritoService->shouldReceive('addFavorito')->never();
        $h4 = Mockery::mock(PersisteProdutoFavoritoClienteHandler::class, [$favoritoService])->makePartial()->shouldAllowMockingProtectedMethods();

        $h5 = Mockery::mock(PadronizaRetornoContextoHandler::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $h5->shouldReceive('process')->once()->andReturnUsing(fn(FavoritoContext $c) => $c->retorno = (object) ['duplicado' => true]);

        $this->app->instance(ResolveClienteHandler::class, $h1);
        $this->app->instance(ConsultaApiExternaExistenciaProdutoHandler::class, $h2);
        $this->app->instance(VerificaProdutoDuplicadoHandler::class, $h3);
        $this->app->instance(PersisteProdutoFavoritoClienteHandler::class, $h4);
        $this->app->instance(PadronizaRetornoContextoHandler::class, $h5);

        $uc = new AddFavorito();
        $contexto = new FavoritoContext($uuid2, '88');

        $retorno = $uc($contexto);

        $this->assertSame($contexto, $retorno);
        $this->assertTrue($retorno->produtoExisteListaCliente);
        $this->assertNull($retorno->produtoFavorito);
    }

    #[Test]
    public function nao_persiste_quando_api_externa_nao_confirma_produto(): void
    {
        $clienteRepo = Mockery::mock(ClienteRepositoryInterface::class);
        $uuid = (string) \Illuminate\Support\Str::uuid();
        $cliente     = Cliente::factory()->make(['uuid' => $uuid]);
        $cliente->setAttribute('id', 44);
        $clienteRepo->shouldReceive('findByUuid')->andReturn($cliente);
        $h1 = Mockery::mock(ResolveClienteHandler::class, [$clienteRepo])->makePartial()->shouldAllowMockingProtectedMethods();

        $api = Mockery::mock(ApiExternaProdutoIntegration::class);
        $h2  = Mockery::mock(ConsultaApiExternaExistenciaProdutoHandler::class, [$api])->makePartial()->shouldAllowMockingProtectedMethods();
        $h2->shouldReceive('process')->once()->andReturnUsing(fn(FavoritoContext $c) => $c->produtoExisteValidacaoExterna = false);

        $h3 = Mockery::mock(VerificaProdutoDuplicadoHandler::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $h3->shouldReceive('process')->once()->andReturnUsing(fn(FavoritoContext $c) => $c->produtoExisteListaCliente = false);

        $favoritoService = Mockery::mock(FavoritoService::class)->makePartial();
        $favoritoService->shouldReceive('addFavorito')->never();
        $h4 = Mockery::mock(PersisteProdutoFavoritoClienteHandler::class, [$favoritoService])->makePartial()->shouldAllowMockingProtectedMethods();

        $h5 = Mockery::mock(PadronizaRetornoContextoHandler::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $h5->shouldReceive('process')->once()->andReturnUsing(fn(FavoritoContext $c) => $c->retorno = (object) ['ok' => false]);


        $this->app->instance(ResolveClienteHandler::class, $h1);
        $this->app->instance(ConsultaApiExternaExistenciaProdutoHandler::class, $h2);
        $this->app->instance(VerificaProdutoDuplicadoHandler::class, $h3);
        $this->app->instance(PersisteProdutoFavoritoClienteHandler::class, $h4);
        $this->app->instance(PadronizaRetornoContextoHandler::class, $h5);

        $uc  = new AddFavorito();
        $contexto = new FavoritoContext($uuid, '99');

        $retorno = $uc($contexto);

        $this->assertSame($contexto, $retorno);
        $this->assertFalse($retorno->produtoExisteValidacaoExterna);
        $this->assertNull($retorno->produtoFavorito);
    }
}
