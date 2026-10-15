<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PainelController extends Controller
{
    public function index(): View
    {
        $usuario = Auth::user();

        // Mude para 'painel' em vez de 'auth.painel'
        return view('painel', [
            'nomeUsuario' => $usuario->name ?? $usuario->nome ?? 'Usuário',
            'tipoUsuario' => $usuario->tipo_usuario ?? 'paciente',
        ]);
    }
}