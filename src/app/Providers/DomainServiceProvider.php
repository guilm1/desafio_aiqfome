<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Cliente\Services\ClienteService;
use App\Domain\Favorito\Services\FavoritoService;
use App\Domain\Produto\Services\ProdutoService;
use App\Domain\Cliente\Services\Contracts\ClienteServiceInterface;
use App\Domain\Favorito\Services\Contracts\FavoritoServiceInterface;
use App\Domain\Produto\Services\Contracts\ProdutoServiceInterface;
use App\Domain\Produto\Integrations\Contracts\ProdutoIntegrationInterface;
use App\Domain\Produto\Integrations\ApiExternaProdutoIntegration;

class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ClienteServiceInterface::class, ClienteService::class);
        $this->app->bind(ProdutoServiceInterface::class, ProdutoService::class);
        $this->app->bind(ProdutoIntegrationInterface::class, ApiExternaProdutoIntegration::class);
        $this->app->bind(FavoritoServiceInterface::class, FavoritoService::class);
    }

    public function boot(): void
    {
        //
    }
}
