<?php

namespace App\Http\Requests\Cliente;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeEmailClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $uuid = $this->route('uuid');

        return [
            'email' => [
                'required',
                'email:rfc,dns',
                Rule::unique('cliente', 'email')->ignore($uuid, 'uuid'),
            ],
        ];
    }
}
