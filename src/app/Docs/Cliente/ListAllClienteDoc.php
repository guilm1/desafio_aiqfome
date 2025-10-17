<?php

namespace App\Docs\Cliente;

use OpenApi\Annotations as OA;

final class ListAllClienteDoc
{
    /**
     * @OA\Get(
     *   path="/api/cliente/list-all",
     *   operationId="clienteListAll",
     *   tags={"Cliente"},
     *   summary="Listar todos os clientes",
     *   description="Retorna a lista completa de clientes.",
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
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       required={"data","success","message"},
     *       @OA\Property(
     *         property="data",
     *         type="array",
     *         @OA\Items(
     *           type="object",
     *           required={"nome","email","uuid"},
     *           @OA\Property(property="nome", type="string", example="Usuário API Aiqfome"),
     *           @OA\Property(property="email", type="string", example="usuariodesafioapiaiqfome2025@aiqfome.com"),
     *           @OA\Property(property="uuid", type="string", format="uuid", example="9e8c95f2-a0dd-4369-9b1a-92f9c1d9b456")
     *         )
     *       ),
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="Clientes encontrados com sucesso")
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
     *     response=204,
     *     description="Sem conteúdo (nenhum cliente encontrado)"
     *   )
     * )
     */
    private function listAll() {}
}
