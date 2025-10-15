<?php

use App\Http\Middleware\ValidateApiKeyMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: array_map(
            fn($file) => realpath(__DIR__ . '/../routes/api/' . $file),
            array_filter(scandir(__DIR__ . '/../routes/api'), fn($file) => str_ends_with($file, '.php'))
        ),
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php'
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            // 'auth'             => Authenticate::class,
            'validate.api.key' => ValidateApiKeyMiddleware::class,
            // 'policy.access'    => CheckServicePolicy::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
