<?php

namespace App\Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *   name="Health",
 *   description="Endpoints de verificação de saúde da API"
 * )
 */
final class HealthCheckDoc
{
    /**
     * @OA\Get(
     *   path="/api/health",
     *   operationId="healthCheck",
     *   tags={"Health"},
     *   summary="Health check da API",
     *   description="Retorna se a API está operacional e o timestamp atual do servidor.",
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       required={"up","time"},
     *       @OA\Property(
     *         property="up",
     *         type="boolean",
     *         example=true,
     *         description="Indica se o serviço está funcional"
     *       ),
     *       @OA\Property(
     *         property="time",
     *         type="string",
     *         format="date-time",
     *         example="2025-10-17T17:46:52+00:00",
     *         description="Horário atual do servidor em ISO 8601"
     *       )
     *     ),
     *     content={
     *       "application/json": {
     *         "example": {"up": true, "time": "2025-10-17T17:46:52+00:00"}
     *       }
     *     }
     *   ),
     *   @OA\Response(
     *     response=503,
     *     description="Serviço indisponível"
     *   )
     * )
     */
    private function health() {}
}
