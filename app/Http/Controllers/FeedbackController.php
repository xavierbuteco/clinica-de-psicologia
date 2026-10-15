<?php

namespace App\Http\Controllers\Psicologo;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrarFeedbackRequest;
use App\Models\Consulta;
use App\Models\Feedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function store(RegistrarFeedbackRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $psicologo = Auth::user();

        $consulta = Consulta::where('id', $dados['consulta_id'])
            ->where('psicologo_id', $psicologo->id)
            ->firstOrFail();

        Feedback::create([
            'consulta_id' => $consulta->id,
            'paciente_id' => $consulta->paciente_id,
            'psicologo_id' => $psicologo->id,
            'tipo' => $dados['tipo'],
            'conteudo' => $dados['conteudo'],
        ]);

        return back()->with('sucesso', 'Feedback registrado e visível para o paciente.');
    }
}
