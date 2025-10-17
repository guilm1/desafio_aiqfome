<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Favorito\AddFavoritoRequest;
use App\Domain\Favorito\UseCases\AddFavorito;
use App\Domain\Favorito\UseCases\RemoveFavorito;
use App\Domain\Favorito\UseCases\FindFavoritosByUuidCliente;
use App\Domain\Favorito\UseCases\Context\FavoritoContext;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Domain\Favorito\Exceptions\ProdutoJaAdicionadoException;
use App\Domain\Favorito\Exceptions\ProdutoNaoExisteCartelaClienteException;
use App\Domain\Favorito\Exceptions\NaoPossuiProdutosException;

class FavoritoController extends Controller
{
    private $return;
    private $code;
    private $message;
    private $success;

    /**
     * Set default values to return in
     */
    public function __construct()
    {
        $this->return  = false;
        $this->code    = config('httpstatus.success.ok');
        $this->message = null;
        $this->success = true;
    }

    public function addFavorito(AddFavoritoRequest $request, string $uuidCliente, AddFavorito $add)
    {
        try {
            $contexto = new FavoritoContext(
                uuidCliente: $uuidCliente,
                produtoId: $request->validated('produto_id'),
                request: $request
            );
            $this->return = $add($contexto)?->retorno;
        } catch (ModelNotFoundException $e) {
            $this->return = null;
            $this->success = false;
            $this->code = config('httpstatus.client_error.bad_request');
            $this->message = $e->getMessage();
        } catch (ProdutoJaAdicionadoException $e) {
            $this->return = null;
            $this->success = false;
            $this->code = config('httpstatus.client_error.bad_request');
            $this->message = $e->getMessage();
        } catch (\Exception $e) {
            $this->return = null;
            $this->success = false;
            $this->code = config('httpstatus.client_error.unprocessable_entity');
            $this->message = "Não foi possível processar a instrução fornecida";
        }

        return collection($this->return, $this->code, $this->message, $this->success);
    }

    public function remove(string $uuidCliente, int $produtoId, RemoveFavorito $del)
    {
        try {
            $contexto = new FavoritoContext(
                uuidCliente: $uuidCliente,
                produtoId: $produtoId
            );
            $this->return = !! $del($contexto);
            $this->message = "Favorito removido com sucesso";
            $this->code    = config('httpstatus.success.ok');
        } catch (ModelNotFoundException $e) {
            $this->return = null;
            $this->success = false;
            $this->code = config('httpstatus.client_error.bad_request');
            $this->message = $e->getMessage();
        } catch (ProdutoNaoExisteCartelaClienteException $e) {
            $this->return = null;
            $this->success = false;
            $this->code = config('httpstatus.client_error.bad_request');
            $this->message = $e->getMessage();
        } catch (\Exception $e) {
            $this->return = null;
            $this->success = false;
            $this->code = config('httpstatus.client_error.unprocessable_entity');
            $this->message = "Não foi possível processar a instrução fornecida";
            $this->success = false;
        }
        return collection($this->return, $this->code, $this->message, $this->success);
    }

    public function findByUuid(string $uuidCliente, FindFavoritosByUuidCliente $findFavoritosByUuidUsuario)
    {
        try {
            $contexto = new FavoritoContext(
                uuidCliente: $uuidCliente,
                produtoId: null
            );
            $this->return = $findFavoritosByUuidUsuario($contexto);
        } catch (ModelNotFoundException $e) {
            $this->return = null;
            $this->success = false;
            $this->code = config('httpstatus.client_error.bad_request');
            $this->message = $e->getMessage();
        } catch (NaoPossuiProdutosException $e) {
            $this->return = null;
            $this->success = false;
            $this->code = config('httpstatus.client_error.unprocessable_entity');
            $this->message = $e->getMessage();
            $this->success = false;
        } catch (\Exception $e) {
            $this->return = null;
            $this->success = false;
            $this->code = config('httpstatus.client_error.unprocessable_entity');
            $this->message = "Não foi possível processar a instrução fornecida";
            $this->success = false;
        }
        return collection($this->return, $this->code, $this->message, $this->success);
    }
}
