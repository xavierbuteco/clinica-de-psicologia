<?php

namespace App\Http\Requests;

use App\Models\Consulta;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgendarConsultaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'data' => ['required', 'date', 'after_or_equal:today'],
            'hora' => ['required', 'date_format:H:i'],
            'tipo_consulta' => ['required', Rule::in(array_keys(Consulta::tiposDisponiveis()))],
            'laudo' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'], // 10 MB
            'observacoes' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'data.required' => 'Escolha a data da consulta.',
            'data.after_or_equal' => 'A data da consulta não pode ser no passado.',
            'hora.required' => 'Escolha o horário da consulta.',
            'hora.date_format' => 'Informe um horário válido.',
            'tipo_consulta.required' => 'Escolha o tipo de consulta.',
            'tipo_consulta.in' => 'Tipo de consulta inválido.',
            'laudo.file' => 'O laudo enviado é inválido.',
            'laudo.mimes' => 'O laudo deve ser um PDF, JPG ou PNG.',
            'laudo.max' => 'O laudo deve ter no máximo 10MB.',
            'observacoes.max' => 'As observações devem ter no máximo 2000 caracteres.',
        ];
    }
}
