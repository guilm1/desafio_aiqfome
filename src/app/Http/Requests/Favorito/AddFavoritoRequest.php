<?php

namespace App\Http\Requests\Favorito;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddFavoritoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function validationData(): array
    {
        $data = $this->all();
        $data['uuid'] = $this->route('uuid');

        return $data;
    }

    public function rules(): array
    {
        return [
            'produto_id'  => [
                'required',
                'integer'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'produto_id.required' => 'O campo produto_id é obrigatório.',
            'produto_id.integer' => 'O campo produto_id deve ser um inteiro.'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'code'  => config('httpstatus.client_error.unprocessable_entity'),
            'errors'  => $validator->errors(),
        ], config('httpstatus.client_error.unprocessable_entity')));
    }
}
