<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Cliente\UseCases\CreateCliente;
use App\Domain\Cliente\UseCases\UpdateCliente;
use App\Domain\Cliente\UseCases\ListAllCliente;
use App\Domain\Cliente\UseCases\FindByUuidCliente;
use App\Domain\Cliente\UseCases\RemoveCliente;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\Cliente\CreateClienteRequest;
use App\Http\Requests\Cliente\UpdateClienteRequest;

class ClienteController extends Controller
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

    public function listAll(ListAllCliente $listAll)
    {
        $this->return = $listAll();
        $this->message = 'Clientes encontrados com sucesso';
        if (count($this->return) === 0) {
            $this->message = 'Nenhum cliente encontrado';
            $this->success = false;
            $this->code = config('httpstatus.success.no_content');
        }
        return collection($this->return, $this->code, $this->message, $this->success);
    }

    public function findByUuid(FindByUuidCliente $findByUuid, string $uuid)
    {
        try {
            $this->return = $findByUuid($uuid);
            $this->message = 'Cliente encontrado com sucesso';
        } catch (ModelNotFoundException $e) {
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

    public function create(CreateClienteRequest $request, CreateCliente $create)
    {
        try {
            $this->return = $create($request->validated());
            $this->message = 'Cliente criado com sucesso';
            $this->code = config('httpstatus.success.created');        
        } catch (\Exception $e) {
            $this->return = null;
            $this->success = false;
            $this->code = config('httpstatus.client_error.unprocessable_entity');
            $this->message = "Não foi possível processar a instrução fornecida";
        }        
        return collection($this->return, $this->code, $this->message);
    }

    public function update(UpdateClienteRequest $request, UpdateCliente $update, string $uuid)
    {
        try {
            $this->return = $update($uuid, $request->validated());
            $this->message = 'Cliente atualizado com sucesso';
        } catch (ModelNotFoundException $e) {
            $this->return = null;
            $this->success = false;
            $this->code = config('httpstatus.client_error.bad_request');
            $this->message = $e->getMessage();
        } catch (\Throwable $e) {
            $this->return = null;
            $this->success = false;
            $this->code = config('httpstatus.client_error.unprocessable_entity');
            $this->message = "Não foi possível processar a instrução fornecida";
        }
        return collection($this->return, $this->code, $this->message, $this->success);
    }

    public function remove(RemoveCliente $removeCliente, string $uuid)
    {
        try {
            $this->return = $removeCliente($uuid);
            $this->message = 'Cliente removido com sucesso';
        } catch (ModelNotFoundException $e) {
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
}
