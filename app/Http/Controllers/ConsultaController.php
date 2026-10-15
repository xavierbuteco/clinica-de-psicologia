<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgendarConsultaRequest;
use App\Models\Consulta;
use App\Models\Feedback;
use App\Models\Mensagem;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ConsultaController extends Controller
{
    public function index(): View
    {
        /** @var \App\Models\User $paciente */
        $paciente = Auth::user();

        $psicologo = $paciente->consultasComoPaciente()
            ->whereNotNull('psicologo_id')
            ->latest('data')
            ->first()?->psicologo
            ?? User::where('tipo_usuario', 'psicologo')->first();

        $consultasAgendadas = $paciente->consultasComoPaciente()
            ->with('psicologo')
            ->orderByDesc('data')
            ->orderByDesc('hora')
            ->get();

        // Mapeia e formata as datas para o calendário no JavaScript
        $datasConsultasFormatted = $consultasAgendadas->map(function ($consulta) {
            return Carbon::parse($consulta->data)->format('Y-m-d');
        })->values();

        $mensagens = collect();

        if ($psicologo) {
            $mensagens = Mensagem::where(function ($query) use ($paciente, $psicologo) {
                $query->where(function ($q) use ($paciente, $psicologo) {
                    $q->where('remetente_id', $paciente->id)
                      ->where('destinatario_id', $psicologo->id);
                })->orWhere(function ($q) use ($paciente, $psicologo) {
                    $q->where('remetente_id', $psicologo->id)
                      ->where('destinatario_id', $paciente->id);
                });
            })
            ->orderBy('created_at')
            ->get();
        }

       $feedbacks = Feedback::from('feedbacks')
    ->where('paciente_id', $paciente->id)
    ->with(['psicologo', 'consulta'])
    ->latest()
    ->get();

        return view('consultas.index', [
            'tiposConsulta' => Consulta::tiposDisponiveis(),
            'consultasAgendadas' => $consultasAgendadas,
            'datasConsultasFormatted' => $datasConsultasFormatted,
            'psicologo' => $psicologo,
            'mensagens' => $mensagens,
            'feedbacks' => $feedbacks,
        ]);
    }

    public function store(AgendarConsultaRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        /** @var \App\Models\User $paciente */
        $paciente = Auth::user();

        $psicologo = $paciente->consultasComoPaciente()
            ->whereNotNull('psicologo_id')
            ->latest('data')
            ->first()?->psicologo
            ?? User::where('tipo_usuario', 'psicologo')->first();

        if (!$psicologo) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['psicologo' => 'Nenhum profissional disponível para agendamento no momento.']);
        }

        $laudoPath = null;
        if ($request->hasFile('laudo')) {
            $laudoPath = $request->file('laudo')->store('laudos', 'private');
        }

        Consulta::create([
            'paciente_id' => $paciente->id,
            'psicologo_id' => $psicologo->id,
            'data' => $dados['data'],
            'hora' => $dados['hora'],
            'tipo_consulta' => $dados['tipo_consulta'],
            'laudo_path' => $laudoPath,
            'observacoes' => $dados['observacoes'] ?? null,
        ]);

        return redirect()
            ->route('consultas.index')
            ->with('sucesso', 'Consulta agendada com sucesso!');
    }
}