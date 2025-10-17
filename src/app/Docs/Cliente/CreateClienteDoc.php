<?php

namespace App\Docs\Cliente;

use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *   name="Cliente",
 *   description="Operações de clientes"
 * )
 *
 */
final class CreateClienteDoc
{
    /**
     * @OA\Post(
     *   path="/api/cliente/create",
     *   operationId="clienteCreate",
     *   tags={"Cliente"},
     *   summary="Criar cliente",
     *   description="Cria um novo cliente a partir de nome e e-mail.",
     *   security={{"bearerAuth":{}}},
     *
     *   @OA\Parameter(
     *     name="X-API-KEY",
     *     in="header",
     *     required=true,
     *     description="Chave da aplicação para acesso à API",
     *     @OA\Schema(type="string", default="36646fa1-f915-404f-b8aa-9ebe5a61a479")
     *   ),
     *     
     *
     *   @OA\RequestBody(
     *     required=true,
     *     description="Dados do cliente",
     *     @OA\JsonContent(
     *       required={"nome","email"},
     *       @OA\Property(
     *         property="nome", type="string", example="Usuário API Aiqfome",
     *         description="Nome completo do cliente"
     *       ),
     *       @OA\Property(
     *         property="email", type="string", format="email",
     *         example="usuariodesafioapiaiqfome2025@aiqfome.com",
     *         description="E-mail único do cliente"
     *       )
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=201,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       required={"data","success","message"},
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         required={"nome","email","uuid"},
     *         @OA\Property(property="nome", type="string", example="Usuário API Aiqfome"),
     *         @OA\Property(property="email", type="string", example="usuariodesafioapiaiqfomes@aiqfome.com"),
     *         @OA\Property(property="uuid", type="string", format="uuid", example="17c0d104-6b2c-4535-a409-4bf102849a86")
     *       ),
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="Cliente criado com sucesso")
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
     *         required={"success","code","errors"},
     *         @OA\Property(property="success", type="boolean", example=false),
     *         @OA\Property(property="code", type="integer", example=422),
     *         @OA\Property(
     *           property="errors",
     *           type="object",
     *           @OA\Property(
     *             property="email",
     *             type="array",
     *             @OA\Items(type="string", example="O email informado já está em uso.")
     *           ),
     *           @OA\Property(
     *             property="nome",
     *             type="array",
     *             @OA\Items(type="string", example="O campo nome é obrigatório.")
     *           )
     *         )
     *       ),
     *       @OA\Examples(
     *         example="email_em_uso",
     *         summary="E-mail já cadastrado",
     *         value={"success":false,"code":422,"errors":{"email":{"O email informado já está em uso."}}}
     *       ),
     *       @OA\Examples(
     *         example="nome_obrigatorio_e_email_em_uso",
     *         summary="Nome ausente e e-mail em uso",
     *         value={"success":false,"code":422,"errors":{"nome":{"O campo nome é obrigatório."},"email":{"O email informado já está em uso."}}}
     *       )
     *     )
     *   )
     * )
     */
    private function create() {}
}
