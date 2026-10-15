<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CadastroUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'senha' => [
                'required',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
            'tipo_usuario' => ['required', Rule::in(['paciente', 'psicologo'])],
            'crp' => [
                Rule::requiredIf(fn () => $this->input('tipo_usuario') === 'psicologo'),
                'nullable',
                'regex:/^(0[1-9]|1[0-9]|2[0-4])\/[0-9]{4,6}$/',
                Rule::unique('users', 'crp'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'Preencha todos os campos!',
            'email.required' => 'Preencha todos os campos!',
            'email.email' => 'Por favor, insira um e-mail válido!',
            'email.unique' => 'Este e-mail já está cadastrado!',
            'senha.required' => 'Preencha todos os campos!',
            'senha.min' => 'A senha deve ter no mínimo 8 caracteres, incluindo pelo menos uma letra maiúscula, um número e um caractere especial.',
            'senha.mixed' => 'A senha deve ter no mínimo 8 caracteres, incluindo pelo menos uma letra maiúscula, um número e um caractere especial.',
            'senha.numbers' => 'A senha deve ter no mínimo 8 caracteres, incluindo pelo menos uma letra maiúscula, um número e um caractere especial.',
            'senha.symbols' => 'A senha deve ter no mínimo 8 caracteres, incluindo pelo menos uma letra maiúscula, um número e um caractere especial.',
            'tipo_usuario.required' => 'Preencha todos os campos!',
            'crp.required' => 'O número do CRP é obrigatório para psicólogos!',
            'crp.regex' => 'Formato de CRP inválido! Use o formato: Região/Número (ex: 06/123456).',
            'crp.unique' => 'Este CRP já está cadastrado no sistema!',
        ];
    }

}
