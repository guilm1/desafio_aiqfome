<?php

namespace App\Domain\Produto\Integrations;

use GuzzleHttp\Client;
use App\Domain\Produto\Integrations\Contracts\ProdutoIntegrationInterface;

class ApiExternaProdutoIntegration implements ProdutoIntegrationInterface
{
    private $camposIntegracao;

    public function __construct()
    {
        $this->camposIntegracao = \getCamposIntegracao("APE");
    }

    private function getHeaders(): array
    {
        return [
            'Accept' => 'application/json',
        ];
    }

    private function getClient(): Client
    {
        return new Client([
            'base_uri' => rtrim($this->camposIntegracao['URL'], '/') . '/',
            'timeout'  => 10.0,
        ]);
    }

    public function listAll(): object
    {
        try {
            $client = $this->getClient();
            $response = $client->get('products', ['headers' => $this->getHeaders()]);

            $status = $response->getStatusCode();
            $data   = json_decode((string) $response->getBody(), true);

            return (object) [
                'success' => $status === 200,
                'status'  => $status,
                'data'    => $data,
            ];
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getResponse();
            $status   = $response ? $response->getStatusCode() : null;
            $body     = $response ? (string) $response->getBody() : null;

            return (object) [
                'success' => false,
                'status'  => $status,
                'message' => $e->getMessage(),
                'body'    => $body,
            ];
        }
    }

    public function getProdutoById(int $id): object
    {
        try {
            $client = $this->getClient();
            $response = $client->get('products/' . $id, ['headers' => $this->getHeaders()]);

            $status = $response->getStatusCode();
            $data   = json_decode((string) $response->getBody(), true);

            return (object) [
                'success' => $status === 200,
                'status'  => $status,
                'data'    => $data,
            ];
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getResponse();
            $status   = $response ? $response->getStatusCode() : null;
            $body     = $response ? (string) $response->getBody() : null;

            return (object) [
                'success' => false,
                'status'  => $status,
                'message' => $e->getMessage(),
                'body'    => $body,
            ];
        }
    }
}
