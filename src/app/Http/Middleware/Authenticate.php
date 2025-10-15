<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    /**
     * Manipula a resposta para usuários não autenticados.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $guards
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function unauthenticated($request, array $guards)
    {
        $code = config('httpstatus.client_error.unauthorized');
        throw new HttpResponseException(response()->json([
            'success' => false,
            'code' => $code,
            'message' => 'Acesso não autorizado',
        ], $code));
    }
}
