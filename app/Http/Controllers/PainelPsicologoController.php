<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Consulta;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PainelPsicologoController extends Controller
{
    public function index(): View
    {
        /** @var User $psicologo */
        $psicologo = Auth::user();

        $consultasBase = Consulta::where('psicologo_id', $psicologo->id);

        $totalPacientes = $psicologo->pacientesVinculados()->count();

        $consultasPendentes = (clone $consultasBase)->where('status', 'pendente')->count();

        $consultasSemana = (clone $consultasBase)
            ->whereBetween('data', [now()->startOfWeek(), now()->endOfWeek()])
            ->whereIn('status', ['pendente', 'confirmada'])
            ->count();

        $consultasSemFeedback = (clone $consultasBase)
            ->where('status', 'concluida')
            ->doesntHave('feedbacks')
            ->count();

        $proximasConsultas = (clone $consultasBase)
            ->with('paciente')
            ->whereIn('status', ['pendente', 'confirmada'])
            ->where('data', '>=', now()->toDateString())
            ->orderBy('data')
            ->orderBy('hora')
            ->take(6)
            ->get();

        $pacientesRecentes = $psicologo->pacientesVinculados()
            ->withCount(['consultasComoPaciente as total_consultas' => function ($query) use ($psicologo) {
                $query->where('psicologo_id', $psicologo->id);
            }])
            ->take(6)
            ->get();

        return view('psicologo.painel', [
            'totalPacientes' => $totalPacientes,
            'consultasPendentes' => $consultasPendentes,
            'consultasSemana' => $consultasSemana,
            'consultasSemFeedback' => $consultasSemFeedback,
            'proximasConsultas' => $proximasConsultas,
            'pacientesRecentes' => $pacientesRecentes,
        ]);
    }
}