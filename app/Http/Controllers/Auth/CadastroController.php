<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CadastroUsuarioRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class CadastroController extends Controller
{
    public function create(): View
    {
        return view('auth.cadastro');
    }

    public function store(CadastroUsuarioRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        // app/Http/Controllers/Auth/CadastroController.php

User::create([
    'name'         => $dados['nome'], 
    'email'        => $dados['email'],
    'password'     => Hash::make($dados['senha']),
    'tipo_usuario' => $dados['tipo_usuario'],
    'crp'          => $dados['tipo_usuario'] === 'psicologo' ? $dados['crp'] : null,
]);

        return redirect()
            ->route('login')
            ->with('sucesso', 'Cadastro realizado com sucesso! Faça login para continuar.');
    }
}
