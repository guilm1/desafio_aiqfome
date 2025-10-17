<?php

namespace App\Docs\Favorito;

use OpenApi\Annotations as OA;

final class RemoveFavoritoDoc
{
    /**
     * @OA\Delete(
     *   path="/api/favorito/remove/{uuid}/{produto_id}",
     *   operationId="favoritoRemove",
     *   tags={"Favorito"},
     *   summary="Remover produto dos favoritos do cliente",
     *   description="Remove um produto da lista de favoritos do cliente identificado por UUID.",
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
     *     example="e446ea05-c2cb-41be-824b-60c0f6b9bcbf"
     *   ),
     *   @OA\Parameter(
     *     name="produto_id",
     *     in="path",
     *     required=true,
     *     description="ID do produto a ser removido dos favoritos",
     *     @OA\Schema(type="integer"),
     *     example=15
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       required={"data","success","message"},
     *       @OA\Property(property="data", type="boolean", example=true),
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="Favorito removido com sucesso")
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
     *       oneOf={
     *         @OA\Schema(
     *           type="object",
     *           required={"data","success","message"},
     *           @OA\Property(property="data", nullable=true, type="object", example=null),
     *           @OA\Property(property="success", type="boolean", example=false),
     *           @OA\Property(property="message", type="string", example="Produto não está listado entre os favoritos do cliente.")
     *         ),
     *         @OA\Schema(
     *           type="object",
     *           required={"data","success","message"},
     *           @OA\Property(property="data", nullable=true, type="object", example=null),
     *           @OA\Property(property="success", type="boolean", example=false),
     *           @OA\Property(property="message", type="string", example="Um serviço externo não conseguiu validar a existencia do produto.")
     *         )
     *       }
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
    private function remove() {}
}
