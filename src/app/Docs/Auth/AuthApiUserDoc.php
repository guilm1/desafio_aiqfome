<?php

namespace App\Docs\Auth;

use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *   name="Auth",
 *   description="Autenticação por e-mail e senha"
 * )
 * 
 */
final class AuthApiUserDoc
{
    /**
     * @OA\Post(
     *   path="/api/auth/token",
     *   operationId="authLogin",
     *   tags={"Auth"},
     *   summary="Gerar access token (login)",
     *   description="Autentica o usuário por e-mail e senha e retorna um access token.",     
     *
     *  @OA\Parameter(
     *     name="X-API-KEY",
     *     in="header",
     *     required=true,
     *     description="Chave da aplicação para acesso à API",
     *     @OA\Schema(type="string"),
     *     example="36646fa1-f915-404f-b8aa-9ebe5a61a479"
     *   ),
     * 
     *   @OA\RequestBody(
     *     required=true,
     *     description="Credenciais do usuário",
     *     @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(
     *         property="email",
     *         type="string",
     *         format="email",
     *         example="aiqfomeapi@aiqfome.com.br",
     *         description="E-mail do usuário"
     *       ),
     *       @OA\Property(
     *         property="password",
     *         type="string",
     *         format="password",
     *         example="4NkiFzUUwmhhbFYEggoZ",
     *         description="Senha do usuário"
     *       )
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       required={"success","access_token","token_type"},
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(
     *         property="access_token",
     *         type="string",
     *         example="1|tLjvaiXAmx5Gx0hzCBhmgpGsyAkHT9TYOfpBdPfQ2d2e1",
     *         description="Token de acesso (use no Authorization: Bearer ...)"
     *       ),
     *       @OA\Property(property="token_type", type="string", example="Bearer")
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         type="object",
     *         required={"code","success","message"},
     *         @OA\Property(property="code", type="integer", example=401),
     *         @OA\Property(property="success", type="boolean", example=false),
     *         @OA\Property(property="message", type="string", example="Credenciais inválidas.")
     *       ),
     *       @OA\Examples(
     *         example="invalid_credentials",
     *         summary="Credenciais inválidas",
     *         value={"code":401,"success":false,"message":"Credenciais inválidas."}
     *       ),
     *       @OA\Examples(
     *         example="missing_or_invalid_api_key",
     *         summary="API Key inválida ou ausente",
     *         value={"code":401,"success":false,"message":"API Key inválida ou ausente."}
     *       )
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=422,
     *     description="Unprocessable Content (erros de validação)",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         type="object",
     *         required={"success","status","errors"},
     *         @OA\Property(property="success", type="boolean", example=false),
     *         @OA\Property(property="status", type="integer", example=422),
     *         @OA\Property(
     *           property="errors",
     *           type="object",
     *           @OA\Property(
     *             property="email",
     *             type="array",
     *             @OA\Items(type="string", example="O e-mail informado não é válido.")
     *           ),
     *           @OA\Property(
     *             property="password",
     *             type="array",
     *             @OA\Items(type="string", example="O campo senha é obrigatorio.")
     *           )
     *         )
     *       ),
     *       @OA\Examples(
     *         example="email_invalido",
     *         summary="E-mail inválido",
     *         value={
     *           "success":false,
     *           "status":422,
     *           "errors":{"email":{"O e-mail informado não é válido."}}
     *         }
     *       ),
     *       @OA\Examples(
     *         example="email_invalido_e_password_obrigatorio",
     *         summary="E-mail inválido e senha ausente",
     *         value={
     *           "success":false,
     *           "status":422,
     *           "errors":{
     *             "email":{"O e-mail informado não é válido."},
     *             "password":{"O campo senha é obrigatorio."}
     *           }
     *         }
     *       )
     *     )
     *   )
     * )
     */
    private function login() {}
}
