<?php

namespace App\Docs\Produto;

use OpenApi\Annotations as OA;

final class GetProdutoByIdDoc
{
    /**
     * @OA\Get(
     *   path="/api/produto/{produto_id}",
     *   operationId="produtoGetById",
     *   tags={"Produto"},
     *   summary="Buscar produto por ID",
     *   description="Retorna os dados de um produto dado seu ID.",
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
     *     name="produto_id",
     *     in="path",
     *     required=true,
     *     description="ID do produto",
     *     @OA\Schema(type="integer"),
     *     example=20
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
     *         required={"id","title","price","description","category","image","rating"},
     *         @OA\Property(property="id", type="integer", example=20),
     *         @OA\Property(property="title", type="string", example="DANVOUY Womens T Shirt Casual Cotton Short"),
     *         @OA\Property(property="price", type="number", format="float", example=12.99),
     *         @OA\Property(property="description", type="string", example="95%Cotton,5%Spandex, Features: Casual, Short Sleeve..."),
     *         @OA\Property(property="category", type="string", example="women's clothing"),
     *         @OA\Property(property="image", type="string", format="uri", example="https://fakestoreapi.com/img/61pHAEJ4NML._AC_UX679_t.png"),
     *         @OA\Property(
     *           property="rating",
     *           type="object",
     *           required={"rate","count"},
     *           @OA\Property(property="rate", type="number", format="float", example=3.6),
     *           @OA\Property(property="count", type="integer", example=145)
     *         )
     *       ),
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="Produto encontrado com sucesso")
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
     *       @OA\Property(property="message", type="string", example="Produto não encontrado")
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=500,
     *     description="Server Error",
     *     @OA\JsonContent(
     *       type="object",
     *       required={"data","success","message"},
     *       @OA\Property(property="data", nullable=true, type="object", example=null),
     *       @OA\Property(property="success", type="boolean", example=false),
     *       @OA\Property(property="message", type="string", example="Houve um problema interno com a integração")
     *     )
     *   )
     * )
     */
    private function getProdutoById() {}
}
