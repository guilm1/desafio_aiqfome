<?php

namespace App\Http\Requests\Cliente;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'email:rfc,dns', Rule::unique('cliente', 'email')]
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required'  => 'O campo nome é obrigatório.',
            'nome.string'    => 'O campo nome deve ser uma string.',
            'nome.max'       => 'O campo nome não deve exceder 255 caracteres.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email'    => 'O campo email deve ser um endereço de email válido.',
            'email.unique'   => 'O email informado já está em uso.'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'code'  => config('httpstatus.client_error.unprocessable_entity'),
            'errors'  => $validator->errors(),
        ], config('httpsstatus.client_error.unprocessable_entity')));
    }
}
