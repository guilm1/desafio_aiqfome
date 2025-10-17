<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ClienteRepository;
use App\Repositories\FavoritoRepository;
use App\Repositories\Interfaces\ClienteRepositoryInterface;
use App\Repositories\Interfaces\FavoritoRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ClienteRepositoryInterface::class, ClienteRepository::class);
        $this->app->bind(FavoritoRepositoryInterface::class, FavoritoRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
