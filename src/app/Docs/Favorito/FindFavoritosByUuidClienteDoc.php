<?php

namespace App\Docs\Favorito;

use OpenApi\Annotations as OA;

final class FindFavoritosByUuidClienteDoc
{
    /**
     * @OA\Get(
     *   path="/api/favorito/cliente/{uuid}",
     *   operationId="favoritoListByClienteUuid",
     *   tags={"Favorito"},
     *   summary="Listar favoritos do cliente",
     *   description="Retorna a lista de produtos favoritados por um cliente (UUID).",
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
     *           required={"uuid_cliente","produto_id","title","image","price","review"},
     *           @OA\Property(property="uuid_cliente", type="string", format="uuid", example="e446ea05-c2cb-41be-824b-60c0f6b9bcbf"),
     *           @OA\Property(property="produto_id", type="integer", example=13),
     *           @OA\Property(property="title", type="string", example="Acer SB220Q bi 21.5 inches Full HD (1920 x 1080) IPS Ultra-Thin"),
     *           @OA\Property(property="image", type="string", format="uri", example="https://fakestoreapi.com/img/81QpkIctqPL._AC_SX679_t.png"),
     *           @OA\Property(property="price", type="number", format="float", example=599),
     *           @OA\Property(
     *             property="review",
     *             type="object",
     *             required={"rate","count"},
     *             @OA\Property(property="rate", type="number", format="float", example=2.9),
     *             @OA\Property(property="count", type="integer", example=250)
     *           )
     *         )
     *       ),
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="")
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
     *       oneOf={
     *         @OA\Schema(
     *           type="object",
     *           required={"data","success","message"},
     *           @OA\Property(property="data", nullable=true, type="object", example=null),
     *           @OA\Property(property="success", type="boolean", example=false),
     *           @OA\Property(property="message", type="string", example="Cliente não possui favoritos.")
     *         ),
     *         @OA\Schema(
     *           type="object",
     *           required={"data","success","message"},
     *           @OA\Property(property="data", nullable=true, type="object", example=null),
     *           @OA\Property(property="success", type="boolean", example=false),
     *           @OA\Property(property="message", type="string", example="Não foi possível processar a instrução fornecida")
     *         )
     *       }
     *     )
     *   )
     * )
     */
    private function findByUuid() {}
}
