<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\ClienteRepositoryInterface;
use App\Repositories\ClienteRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ClienteRepositoryInterface::class, ClienteRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
