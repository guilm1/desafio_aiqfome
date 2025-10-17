<?php

namespace Tests\Unit\Domain\Cliente\Services;

use App\Domain\Cliente\Services\ClienteService;
use App\Models\Cliente;
use App\Repositories\Interfaces\ClienteRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Depends;

#[CoversClass(ClienteService::class)]
#[Group('unit')]
class ClienteServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @var ClienteRepositoryInterface&MockInterface */
    private $repo;

    private ClienteService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = Mockery::mock(ClienteRepositoryInterface::class);
        $this->service = new ClienteService($this->repo);
    }

    #[Test]
    public function cria_persiste_cliente_e_retorna_model(): void
    {
        $payload = ['nome' => 'Cliente Aiqfome', 'email' => 'cliente@aiqfome.com.br'];
        $cliente = $this->service->create($payload);

        $this->assertInstanceOf(Cliente::class, $cliente);
        $this->assertDatabaseHas('cliente', ['email' => 'cliente@aiqfome.com.br', 'nome' => 'Cliente Aiqfome']);
    }

    #[Test]
    public function atualiza_altera_campos_e_retorna_model(): void
    {
        $uuid = (string) \Illuminate\Support\Str::uuid();
        $cliente = Cliente::factory()->create([
            'uuid'  => $uuid,
            'nome'  => 'Cliente Aiqfome Old',
            'email' => 'old.cliente@aiqfome.com.br',
        ]);

        $this->repo->shouldReceive('findByUuid')
            ->once()->with($uuid)->andReturn($cliente);

        $retorno = $this->service->update($uuid, [
            'nome'  => 'Cliente Aiqfome New',
            'email' => 'new.cliente@aiqfome.com.br',
        ]);

        $this->assertTrue($cliente->is($retorno));
        $this->assertEquals('Cliente Aiqfome New', $retorno->nome);
        $this->assertEquals('new.cliente@aiqfome.com.br', $retorno->email);
        $this->assertDatabaseHas('cliente', ['uuid' => $uuid, 'nome' => 'Cliente Aiqfome New']);
    }

    #[Test]
    public function atualiza_lanca_excecao_model_not_found_quando_uuid_inexistente(): void
    {
        $this->repo->shouldReceive('findByUuid')->once()->with('provocando-falha')->andReturn(null);
        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Cliente não encontrado.');

        $this->service->update('provocando-falha', ['nome' => 'Qualquer Nome']);
    }

    #[Test]
    public function findByUuid_retorna_model_quando_existe(): void
    {
        $uuid = (string) \Illuminate\Support\Str::uuid();

        $m = Cliente::factory()->make(['uuid' => $uuid]);
        $this->repo->shouldReceive('findByUuid')->once()->with($uuid)->andReturn($m);

        $retorno = $this->service->findByUuid($uuid);

        $this->assertInstanceOf(Cliente::class, $retorno);
        $this->assertEquals($uuid, $retorno->uuid);
    }

    #[Test]
    public function findByUuid_lanca_model_not_found_quando_nulo(): void
    {
        $uuid = (string) \Illuminate\Support\Str::uuid();

        $this->repo->shouldReceive('findByUuid')->once()->with($uuid)->andReturn(null);

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Cliente não encontrado.');

        $this->service->findByUuid($uuid);
    }

    #[Test]
    public function destroy_retorna_true_quando_repo_apaga(): void
    {
        $uuid = (string) \Illuminate\Support\Str::uuid();
        $this->repo->shouldReceive('destroy')->once()->with($uuid)->andReturn(1);
        $this->assertTrue($this->service->destroy($uuid));
    }

    #[Test]
    public function destroy_lanca_model_not_found_quando_repo_retornar_falso(): void
    {
        $uuid = (string) \Illuminate\Support\Str::uuid();
        $this->repo->shouldReceive('destroy')->once()->with($uuid)->andReturn(0);

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Cliente não encontrado.');

        $this->service->destroy($uuid);
    }

    #[Test]
    public function listAll_para_cliente_com_colunas_padroes(): void
    {
        $expected = new EloquentCollection([
            Cliente::factory()->make(['nome' => 'Cliente Aiqfome 1', 'email' => 'cliente1@aiqfome.com']),
            Cliente::factory()->make(['nome' => 'Cliente Aiqfome 2', 'email' => 'cliente2@aiqfome.com']),
        ]);

        $this->repo->shouldReceive('listAll')->once()
            ->with(['nome', 'email', 'uuid'])
            ->andReturn($expected);

        $retorno = $this->service->listAll();

        $this->assertSame($expected, $retorno);
        $this->assertCount(2, $retorno);
    }
}
