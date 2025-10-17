<?php

namespace App\Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *   title="Documentação",
 *   version="1.0.0",
 *   description="Documentação da API de favoritos do Aiqfome
 *      O aiqfome está expandindo seus canais de integração e precisa de uma API robusta para gerenciar os produtos favoritos de usuários na plataforma.
 *      Essa funcionalidade será usada por apps e interfaces web para armazenar e consultar produtos marcados como favoritos pelos clientes. A API terá alto volume de uso e integrará com outros sistemas internos e externos.
 *      Responsável: guilherme.argomes@gmail.com.",
 *   @OA\Contact(
 *     email="guilherme.argomes@gmail.com"
 *   )
 * )
 *
 * @OA\Server(
 *   url="http://localhost:8080",
 *   description="Development"
 * )
 * 
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT"
 * )
 */
final class BaseDoc {}
