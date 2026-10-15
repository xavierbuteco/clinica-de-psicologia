<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'psicologo_id',
        'data',
        'hora',
        'tipo_consulta',
        'laudo_path',
        'observacoes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'date',
        ];
    }

    /**
     * Rótulos amigáveis para os tipos de consulta disponíveis no formulário.
     */
    public static function tiposDisponiveis(): array
    {
        return [
            'primeira_consulta' => 'Primeira Consulta (Avaliação Inicial)',
            'retorno'           => 'Retorno / Acompanhamento',
            'avaliacao'         => 'Avaliação Psicológica',
            'emergencial'       => 'Atendimento Emergencial',
        ];
    }

    /**
     * Rótulos amigáveis para os status do fluxo de agendamento.
     */
    public static function statusDisponiveis(): array
    {
        return [
            'pendente'   => 'Aguardando confirmação',
            'confirmada' => 'Confirmada',
            'concluida'  => 'Concluída',
            'cancelada'  => 'Cancelada',
        ];
    }

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }

    public function psicologo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'psicologo_id');
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    public function anotacoesClinicas(): HasMany
    {
        return $this->hasMany(AnotacaoClinica::class);
    }
}
