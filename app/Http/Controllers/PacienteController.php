<?php

namespace App\Http\Controllers\Psicologo;

use App\Http\Controllers\Controller;
use App\Models\AnotacaoClinica;
use App\Models\Consulta;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PacienteController extends Controller
{
    public function index(): View
    {
        /** @var User $psicologo */
        $psicologo = Auth::user();

        $pacientes = $psicologo->pacientesVinculados()
            ->withCount(['consultasComoPaciente as total_consultas' => function ($query) use ($psicologo) {
                $query->where('psicologo_id', $psicologo->id);
            }])
            ->get();

        return view('psicologo.pacientes', [
            'pacientes' => $pacientes,
        ]);
    }

    public function show(User $paciente): View
    {
        /** @var User $psicologo */
        $psicologo = Auth::user();

        abort_unless(
            Consulta::where('psicologo_id', $psicologo->id)->where('paciente_id', $paciente->id)->exists(),
            403,
            'Este paciente não está vinculado a você.'
        );

        $consultas = Consulta::where('psicologo_id', $psicologo->id)
            ->where('paciente_id', $paciente->id)
            ->orderByDesc('data')
            ->orderByDesc('hora')
            ->get();

        $anotacoesClinicas = AnotacaoClinica::where('psicologo_id', $psicologo->id)
            ->where('paciente_id', $paciente->id)
            ->latest()
            ->get();

        $feedbacksDados = Feedback::where('psicologo_id', $psicologo->id)
            ->where('paciente_id', $paciente->id)
            ->latest()
            ->get();

        return view('psicologo.paciente-mostrar', [
            'paciente' => $paciente,
            'consultas' => $consultas,
            'anotacoesClinicas' => $anotacoesClinicas,
            'feedbacksDados' => $feedbacksDados,
            'tiposConsulta' => Consulta::tiposDisponiveis(),
            'statusDisponiveis' => Consulta::statusDisponiveis(),
            'rotulosFeedback' => Feedback::rotulosTipo(),
        ]);
    }
}