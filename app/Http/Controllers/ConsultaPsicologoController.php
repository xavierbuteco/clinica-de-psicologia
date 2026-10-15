<?php

namespace App\Http\Controllers\Psicologo;

use App\Http\Controllers\Controller;
use App\Models\Consulta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ConsultaPsicologoController extends Controller
{
    public function index(Request $request): View
    {
        $psicologo = Auth::user();

        $filtro = $request->query('status', 'todas');

        $query = Consulta::where('psicologo_id', $psicologo->id)
            ->with('paciente')
            ->orderBy('data')
            ->orderBy('hora');

        if ($filtro !== 'todas') {
            $query->where('status', $filtro);
        }

        return view('psicologo.consultas', [
            'consultas' => $query->get(),
            'statusDisponiveis' => Consulta::statusDisponiveis(),
            'tiposConsulta' => Consulta::tiposDisponiveis(),
            'filtroAtual' => $filtro,
        ]);
    }

    public function confirmar(Consulta $consulta): RedirectResponse
    {
        $this->autorizarConsultaDoPsicologo($consulta);

        $consulta->update(['status' => 'confirmada']);

        return back()->with('sucesso', 'Consulta confirmada.');
    }

    public function recusar(Consulta $consulta): RedirectResponse
    {
        $this->autorizarConsultaDoPsicologo($consulta);

        $consulta->update(['status' => 'cancelada']);

        return back()->with('sucesso', 'Consulta recusada/cancelada.');
    }

    public function concluir(Consulta $consulta): RedirectResponse
    {
        $this->autorizarConsultaDoPsicologo($consulta);

        $consulta->update(['status' => 'concluida']);

        return back()->with('sucesso', 'Consulta marcada como concluída.');
    }

    private function autorizarConsultaDoPsicologo(Consulta $consulta): void
    {
        abort_unless($consulta->psicologo_id === Auth::id(), 403);
    }
}
