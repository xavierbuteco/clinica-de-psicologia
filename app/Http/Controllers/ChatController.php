<?php

namespace App\Http\Controllers;

use App\Models\Mensagem;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ChatController extends Controller
{
    /**
     * Retorna as mensagens trocadas entre o usuário logado e o destinatário.
     * Usado pelo JS da página de consultas para atualizar o chat (polling).
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'destinatario_id' => ['required', 'integer', Rule::exists('users', 'id')],
            'apos_id' => ['nullable', 'integer'],
        ]);

        $usuario = Auth::user();
        $destinatarioId = $request->integer('destinatario_id');

        $query = Mensagem::where(function ($q) use ($usuario, $destinatarioId) {
            $q->where('remetente_id', $usuario->id)->where('destinatario_id', $destinatarioId);
        })->orWhere(function ($q) use ($usuario, $destinatarioId) {
            $q->where('remetente_id', $destinatarioId)->where('destinatario_id', $usuario->id);
        });

        if ($request->filled('apos_id')) {
            $query->where('id', '>', $request->integer('apos_id'));
        }

        $mensagens = $query->orderBy('created_at')->get()->map(fn (Mensagem $m) => [
            'id' => $m->id,
            'mensagem' => $m->mensagem,
            'de_mim' => $m->remetente_id === $usuario->id,
            'criada_em' => $m->created_at->format('H:i'),
        ]);

        return response()->json(['mensagens' => $mensagens]);
    }

    public function store(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'destinatario_id' => ['required', 'integer', Rule::exists('users', 'id')],
            'mensagem' => ['required', 'string', 'max:2000'],
        ]);

        $mensagem = Mensagem::create([
            'remetente_id' => Auth::id(),
            'destinatario_id' => $dados['destinatario_id'],
            'mensagem' => $dados['mensagem'],
        ]);

        return response()->json([
            'mensagem' => [
                'id' => $mensagem->id,
                'mensagem' => $mensagem->mensagem,
                'de_mim' => true,
                'criada_em' => $mensagem->created_at->format('H:i'),
            ],
        ]);
    }
}
