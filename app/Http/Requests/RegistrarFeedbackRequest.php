<?php

namespace App\Http\Requests;

use App\Models\Feedback;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrarFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'consulta_id' => ['required', 'integer', 'exists:consultas,id'],
            'tipo' => ['required', Rule::in(array_keys(Feedback::rotulosTipo()))],
            'conteudo' => ['required', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'consulta_id.required' => 'Selecione a consulta relacionada.',
            'tipo.required' => 'Escolha o tipo de registro.',
            'conteudo.required' => 'Escreva o conteúdo do feedback.',
        ];
    }
}
