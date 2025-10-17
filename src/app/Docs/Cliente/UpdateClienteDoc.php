<?php

namespace App\Docs\Cliente;

use OpenApi\Annotations as OA;

final class UpdateClienteDoc
{
    /**
     * @OA\Put(
     *   path="/api/cliente/update/{uuid}",
     *   operationId="clienteUpdate",
     *   tags={"Cliente"},
     *   summary="Atualizar cliente",
     *   description="Atualiza os dados do cliente pelo UUID.",
     *   security={{"bearerAuth":{}}},
     *
     *   @OA\Parameter(
     *     name="X-API-KEY",
     *     in="header",
     *     required=true,
     *     description="Chave da aplicação para acesso à API",
     *     @OA\Schema(type="string", default="36646fa1-f915-404f-b8aa-9ebe5a61a479")
     *   ),
     *   @OA\Parameter(
     *     name="uuid",
     *     in="path",
     *     required=true,
     *     description="UUID do cliente",
     *     @OA\Schema(type="string", format="uuid"),
     *     example="e0fed027-5f5d-423b-8c57-f66ba379fd5"
     *   ),
     *
     *   @OA\RequestBody(
     *     required=true,
     *     description="Campos permitidos para atualização",
     *     @OA\JsonContent(
     *       @OA\Property(property="nome", type="string", example="Usuário API Aiqfome"),
     *       @OA\Property(property="email", type="string", format="email", example="usuariodesafioapiaiqfome2@aiqfome.com")
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       required={"data","success","message"},
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         required={"uuid","nome","email","created_at","updated_at"},
     *         @OA\Property(property="uuid", type="string", format="uuid", example="17c0d104-6b2c-4535-a409-4bf102849a86"),
     *         @OA\Property(property="nome", type="string", example="Usuário API Aiqfome 2"),
     *         @OA\Property(property="email", type="string", example="usuariodesafioapiaiqfome2@aiqfome.com"),
     *         @OA\Property(property="created_at", type="string", format="date-time", example="2025-10-17T18:09:44.000000Z"),
     *         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-10-17T18:33:35.000000Z")
     *       ),
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="Cliente atualizado com sucesso")
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *     @OA\JsonContent(
     *       oneOf={
     *         @OA\Schema(
     *           type="object",
     *           required={"code","success","message"},
     *           @OA\Property(property="code", type="integer", example=401),
     *           @OA\Property(property="success", type="boolean", example=false),
     *           @OA\Property(property="message", type="string", example="Credenciais inválidas.")
     *         ),
     *         @OA\Schema(
     *           type="object",
     *           required={"code","success","message"},
     *           @OA\Property(property="code", type="integer", example=401),
     *           @OA\Property(property="success", type="boolean", example=false),
     *           @OA\Property(property="message", type="string", example="API Key inválida ou ausente.")
     *         )
     *       }
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=400,
     *     description="Bad Request",
     *     @OA\JsonContent(
     *       type="object",
     *       required={"data","success","message"},
     *       @OA\Property(property="data", nullable=true, type="object", example=null),
     *       @OA\Property(property="success", type="boolean", example=false),
     *       @OA\Property(property="message", type="string", example="Cliente não encontrado.")
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=404,
     *     description="Not Found"
     *   ),
     *
     *   @OA\Response(
     *     response=422,
     *     description="Unprocessable Content",
     *     @OA\JsonContent(
     *       oneOf={
     *         @OA\Schema(
     *           type="object",
     *           required={"data","success","message"},
     *           @OA\Property(property="data", nullable=true, type="object", example=null),
     *           @OA\Property(property="success", type="boolean", example=false),
     *           @OA\Property(property="message", type="string", example="Não foi possível processar a instrução fornecida")
     *         ),
     *         @OA\Schema(
     *           type="object",
     *           required={"success","code","errors"},
     *           @OA\Property(property="success", type="boolean", example=false),
     *           @OA\Property(property="code", type="integer", example=422),
     *           @OA\Property(
     *             property="errors",
     *             type="object",
     *             @OA\Property(
     *               property="email",
     *               type="array",
     *               @OA\Items(type="string", example="O email informado já está em uso.")
     *             )
     *           )
     *         )
     *       }
     *     )
     *   )
     * )
     */
    private function update() {}
}
