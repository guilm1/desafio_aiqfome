<?php

namespace Tests\Unit\Domain\Favorito\UseCases;

use App\Domain\Favorito\UseCases\RemoveFavorito;
use App\Domain\Favorito\UseCases\Context\FavoritoContext;

use App\Domain\Favorito\UseCases\Handlers\ResolveClienteHandler;
use App\Domain\Favorito\UseCases\Handlers\ConsultaApiExternaExistenciaProdutoHandler;
use App\Domain\Favorito\UseCases\Handlers\VerificaExistenciaProdutoFavorito;
use App\Domain\Favorito\UseCases\Handlers\RemoveProdutoFavoritoClienteHandler;
use App\Domain\Favorito\Services\FavoritoService;

use App\Repositories\Interfaces\ClienteRepositoryInterface;
use App\Repositories\FavoritoRepository;
use App\Domain\Produto\Integrations\ApiExternaProdutoIntegration;

use App\Models\Cliente;
use App\Models\ClienteHasProdutosFavoritos;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(RemoveFavorito::class)]
#[Group('unit')]
class RemoveFavoritoTest extends TestCase
{
    #[Test]
    public function executa_cadeia_de_responsabilidades_e_sinaliza_remocao(): void
    {
        /** @var ClienteRepositoryInterface&MockInterface $clienteRepo */
        $clienteRepo = Mockery::mock(ClienteRepositoryInterface::class);
        $uuid = (string) \Illuminate\Support\Str::uuid();
        $cliente = Cliente::factory()->make([
            'uuid'  => $uuid,
            'nome'  => 'Cliente Aiqfome',
            'email' => 'cliente@aiqfome.com.br',
        ]);
        $cliente->setAttribute('id', 30);

        $clienteRepo->shouldReceive('findByUuid')
            ->once()
            ->with($uuid)
            ->andReturn($cliente);

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

        $h2->shouldReceive('process')
            ->once()
            ->andReturnUsing(function (FavoritoContext $contexto) {
                $contexto->produtoExisteValidacaoExterna = true;
            });

        /** @var FavoritoRepository&MockInterface $favoritoRepo */
        $favoritoRepo = Mockery::mock(FavoritoRepository::class);

        /** @var VerificaExistenciaProdutoFavorito&MockInterface $h3 */
        $h3 = Mockery::mock(VerificaExistenciaProdutoFavorito::class, [$favoritoRepo])
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $h3->shouldReceive('process')
            ->once()
            ->andReturnUsing(function (FavoritoContext $contexto) {
                $contexto->produtoExisteListaCliente = true;
                $contexto->produtoFavorito = new ClienteHasProdutosFavoritos([
                    'cliente_id' => 30,
                    'produto_externo_id' => 77,
                ]);
            });

        $favService = Mockery::mock(FavoritoService::class)->makePartial();

        /** @var RemoveProdutoFavoritoClienteHandler&MockInterface $h4 */
        $h4 = Mockery::mock(RemoveProdutoFavoritoClienteHandler::class, [$favService])
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();


        $h4->shouldReceive('process')
            ->once()
            ->andReturnUsing(function (FavoritoContext $contexto) {
                $contexto->success = true;
            });



        $this->app->instance(ResolveClienteHandler::class, $h1);
        $this->app->instance(ConsultaApiExternaExistenciaProdutoHandler::class, $h2);
        $this->app->instance(VerificaExistenciaProdutoFavorito::class, $h3);
        $this->app->instance(RemoveProdutoFavoritoClienteHandler::class, $h4);

        $uc = new RemoveFavorito();
        $contexto = new FavoritoContext($uuid, '77');

        $ret = $uc($contexto);

        $this->assertSame($contexto, $ret);
        $this->assertTrue($ret->produtoExisteValidacaoExterna);
        $this->assertTrue($ret->produtoExisteListaCliente);
        $this->assertTrue($ret->success);
        $this->assertInstanceOf(Cliente::class, $ret->cliente);
        $this->assertEquals(30, $ret->cliente->id);
        $this->assertInstanceOf(ClienteHasProdutosFavoritos::class, $ret->produtoFavorito);
        $this->assertEquals(77, $ret->produtoFavorito->produto_externo_id);
    }

    #[Test]
    public function lanca_excecao_quando_produto_nao_esta_na_lista_do_cliente(): void
    {
        /** @var ClienteRepositoryInterface&MockInterface $clienteRepo */
        $clienteRepo = Mockery::mock(ClienteRepositoryInterface::class);
        $uuid = (string) \Illuminate\Support\Str::uuid();
        $cliente = Cliente::factory()->make(['uuid' => $uuid, 'nome' => 'Cliente Aiqfome', 'email' => 'cliente@aiqfome.com.br']);
        $cliente->setAttribute('id', 42);

        $clienteRepo->shouldReceive('findByUuid')->once()->with($uuid)->andReturn($cliente);
        $h1 = Mockery::mock(ResolveClienteHandler::class, [$clienteRepo])
            ->makePartial()->shouldAllowMockingProtectedMethods();

        $api = Mockery::mock(ApiExternaProdutoIntegration::class);
        $h2 = Mockery::mock(ConsultaApiExternaExistenciaProdutoHandler::class, [$api])
            ->makePartial()->shouldAllowMockingProtectedMethods();
        $h2->shouldReceive('process')->once()->andReturnUsing(function (FavoritoContext $contexto) {
            $contexto->produtoExisteValidacaoExterna = true;
        });

        $favoritoRepo = Mockery::mock(FavoritoRepository::class);
        $h3 = Mockery::mock(VerificaExistenciaProdutoFavorito::class, [$favoritoRepo])
            ->makePartial()->shouldAllowMockingProtectedMethods();
        $h3->shouldReceive('process')
            ->once()
            ->andThrow(new \Exception('Produto favorito não encontrado.'));

        $favService = Mockery::mock(FavoritoService::class)->makePartial();

        $h4 = Mockery::mock(RemoveProdutoFavoritoClienteHandler::class, [$favService])
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $this->app->instance(RemoveProdutoFavoritoClienteHandler::class, $h4);
        $this->app->instance(ResolveClienteHandler::class, $h1);
        $this->app->instance(ConsultaApiExternaExistenciaProdutoHandler::class, $h2);
        $this->app->instance(VerificaExistenciaProdutoFavorito::class, $h3);

        $uc = new RemoveFavorito();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Produto favorito não encontrado.');

        $uc(new FavoritoContext($uuid, '888'));
    }
}
