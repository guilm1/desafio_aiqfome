<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthApiUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class AuthApiUserController extends Controller
{

    /**
     * Utilizado para realizar login do usuario no Sanctum
     *
     * @param AuthApiUserRequest $request
     *
     * @return JsonResponse
     */
    public function login(AuthApiUserRequest $request): JsonResponse
    {
        try {
            $credentials = $request->only('email', 'password');
            $email = $credentials['email'];
            $user = User::where('email', $email)->first();

            if (!$user || !Hash::check($credentials['password'], $user->password)) {
                $message = 'Credenciais inválidas.';
                $code = config('httpstatus.client_error.unauthorized');
                return response()->json([
                    'code' => $code,
                    'success' => false,
                    'message' => $message
                ], $code);
            }

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);
        } catch (\Throwable $th) {
            $code = config('httpstatus.server_error.internal_server_error');
            return response()->json([
                'code' => $code,
                'success' => false,
                'message' => 'Erro ao processar login: ' . $th->getMessage()
            ], $code);
        }
    }
}
