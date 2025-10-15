<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Cliente\Contracts\ClienteServiceInterface;
use App\Domain\Cliente\Services\ClienteService;

class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ClienteServiceInterface::class, ClienteService::class);
    }

    public function boot(): void
    {
        //
    }
}
