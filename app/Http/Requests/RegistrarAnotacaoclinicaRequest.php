<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrarAnotacaoClinicaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

        public function rules(): array
    {
        return [
            'consulta_id' => ['nullable', 'integer', 'exists:consultas,id'],
            'conteudo' => ['required', 'string', 'max:4000'],
        ];
    }

    public function messages(): array
    {
        return [
            'conteudo.required' => 'Escreva a anotação antes de salvar.',
        ];
    }
}
