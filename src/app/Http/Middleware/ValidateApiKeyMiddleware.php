<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey || $apiKey !== config('app.api_key_secret')) {
            $code = config('httpstatus.client_error.unauthorized');
            return response()->json([
                'code' => $code,
                'success' => false,
                'message' => 'API Key inválida ou ausente.'
            ], $code);
        }

        return $next($request);
    }
}
