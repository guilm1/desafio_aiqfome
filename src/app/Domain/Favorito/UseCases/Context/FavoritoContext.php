<?php

namespace App\Domain\Favorito\UseCases\Context;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\ClienteHasProdutosFavoritos;
use Illuminate\Database\Eloquent\Collection;

class FavoritoContext
{
    public string $uuidCliente;
    public ?string $produtoId;
    public ?object $produto;

    public ?Request $request = null;
    public ?object $retorno = null;
    public ?array $retornoLista = [];

    public ?Cliente $cliente = null;
    public ?ClienteHasProdutosFavoritos $produtoFavorito = null;

    public bool $produtoExisteListaCliente = false;
    public bool $produtoExisteValidacaoExterna = false;
    public array $produtosValidados = [];
    public ?Collection $listaFavoritos = null;
    
    public bool $success = false;
    public ?string $message = null;

    public function __construct(string $uuidCliente, ?string $produtoId, ?Request $request = null)
    {
        $this->uuidCliente = $uuidCliente;
        $this->produtoId = $produtoId;
        $this->request = $request;
    }
}
