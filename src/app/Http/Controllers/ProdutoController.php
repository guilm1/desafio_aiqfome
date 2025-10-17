<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Produto\UseCases\GetProdutoById;
use App\Domain\Produto\UseCases\ListAllProduto;

class ProdutoController extends Controller
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

    public function listAll(ListAllProduto $listAllProduto)
    {
        try {
            $this->return = $listAllProduto();
            $this->message = 'Lista de produtos encontrada com sucesso';
            if (count($this->return) === 0) {
                $this->message = 'Nenhum cliente encontrado';
                $this->success = false;
                $this->code = config('httpstatus.success.no_content');
            }
        } catch (\Exception $e) {
            $this->return = null;
            $this->success = false;
            $this->code = config('httpstatus.server_error.internal_server_error');
            $this->message = "Houve um problema interno com a integração";
        }
        return collection($this->return, $this->code, $this->message, $this->success);
    }

    public function getProdutoById(GetProdutoById $getProdutoById, int $id)
    {
        try {
            $this->return = $getProdutoById($id);
            $this->message = 'Produto encontrado com sucesso';
        } catch (\Exception $e) {
            $this->return = null;
            $this->success = false;
            $this->code = config('httpstatus.client_error.bad_request');
            $this->message = $e->getMessage();
        }
        return collection($this->return, $this->code, $this->message, $this->success);
    }
}
