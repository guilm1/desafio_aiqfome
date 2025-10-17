<?php

namespace App\Docs\Produto;

use OpenApi\Annotations as OA;

final class ListAllProdutoDoc
{
    /**
     * @OA\Get(
     *   path="/api/produto/list-all",
     *   operationId="produtoListAll",
     *   tags={"Produto"},
     *   summary="Listar todos os produtos",
     *   description="Retorna a lista completa de produtos.",
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
     *           required={"id","title","price","description","category","image","rating"},
     *           @OA\Property(property="id", type="integer", example=1),
     *           @OA\Property(property="title", type="string", example="Fjallraven - Foldsack No. 1 Backpack, Fits 15 Laptops"),
     *           @OA\Property(property="price", type="number", format="float", example=109.95),
     *           @OA\Property(property="description", type="string", example="Your perfect pack for everyday use and walks in the forest..."),
     *           @OA\Property(property="category", type="string", example="men's clothing"),
     *           @OA\Property(property="image", type="string", format="uri", example="https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_t.png"),
     *           @OA\Property(
     *             property="rating",
     *             type="object",
     *             required={"rate","count"},
     *             @OA\Property(property="rate", type="number", format="float", example=3.9),
     *             @OA\Property(property="count", type="integer", example=120)
     *           )
     *         )
     *       ),
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="Lista de produtos encontrada com sucesso")
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
    private function listAll() {}
}
