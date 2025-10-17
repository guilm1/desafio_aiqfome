<?php

if (! function_exists('collection')) {
    /**
     * Retorna uma resposta JSON padronizada para coleções de dados.
     *
     * @param mixed $data Os dados a serem retornados na resposta.
     * @param int|null $code O código de status HTTP (padrão: 200).
     * @param string|null $message Uma mensagem opcional para incluir na resposta.
     * @param bool $preserveFraction Indica se deve preservar frações decimais (padrão: false).
     * @return \Illuminate\Http\JsonResponse A resposta JSON formatada.
     */
    function collection($data, $code = null, $message = null, $success = true, $preserveFraction = false)
    {
        $code = $code ?? 200;
        $collection = new \stdClass();
        $collection->data = $data;
        $collection->success = $success;
        $collection->message = $message ?? "";
        return $preserveFraction ? response()->json($collection, $code, [], JSON_PRESERVE_ZERO_FRACTION) : response()->json($collection, $code);
    }
}

if (!function_exists('getCamposIntegracao')) {
    function getCamposIntegracao(string $sigla): ?array
    {
        $sistema = \App\Models\IntegracaoServicos::where('sigla', $sigla)->first();
        if (!$sistema) {
            return null;
        }

        $integracao = $sistema->camposIntegracao()->get();
        if (!$integracao) {
            return null;
        }

        $arrayIntegracao = [];
        foreach ($integracao as $item) {
            $arrayIntegracao[$item->sigla] = $item->valor;
        }

        return $arrayIntegracao;
    }
}

if (!function_exists('getProduto')) {
    function getProdutoFavorito(\App\Domain\Favorito\UseCases\Context\FavoritoContext $contexto): object
    {
        return (object) [
            "uuid_cliente" => $contexto->uuidCliente,
            "produto_id" => $contexto->produtoId,
            "title" => $contexto->produto->title,
            "image" => $contexto->produto->image,
            "price" => $contexto->produto->price,
            "review" => $contexto->produto->rating
        ];
    }
}
