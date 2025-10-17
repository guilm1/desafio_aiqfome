<?php

namespace App\Docs\Cliente;

use OpenApi\Annotations as OA;

final class FindByUuidClienteDoc
{
    /**
     * @OA\Get(
     *   path="/api/cliente/{uuid}",
     *   operationId="clienteFindByUuid",
     *   tags={"Cliente"},
     *   summary="Buscar cliente por UUID",
     *   description="Retorna os dados do cliente pelo UUID.",
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
     *     example="17c0d104-6b2c-4535-a409-4bf102849a86"
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
     *         @OA\Property(property="nome", type="string", example="Usuário API Aiqfome"),
     *         @OA\Property(property="email", type="string", example="usuariodesafioapiaiqfomes@aiqfome.com"),
     *         @OA\Property(property="created_at", type="string", format="date-time", example="2025-10-17T18:09:44.000000Z"),
     *         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-10-17T18:09:44.000000Z")
     *       ),
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="Cliente encontrado com sucesso")
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
     *     response=422,
     *     description="Unprocessable Content",
     *     @OA\JsonContent(
     *       type="object",
     *       required={"data","success","message"},
     *       @OA\Property(property="data", nullable=true, type="object", example=null),
     *       @OA\Property(property="success", type="boolean", example=false),
     *       @OA\Property(property="message", type="string", example="Não foi possível processar a instrução fornecida")
     *     )
     *   )
     * )
     */
    private function findByUuid() {}
}
