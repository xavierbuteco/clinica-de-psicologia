<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    use HasFactory;

    /**
     * Tabela associada ao model no banco de dados (PostgreSQL).
     */
    protected $table = 'feedbacks';

    protected $fillable = [
        'consulta_id',
        'paciente_id',
        'psicologo_id',
        'tipo',
        'conteudo',
    ];

    public static function rotulosTipo(): array
    {
        return [
            'feedback' => 'Feedback',
            'ressalva' => 'Ressalva',
            'lembrete' => 'Lembrete',
        ];
    }

    public function consulta(): BelongsTo
    {
        return $this->belongsTo(Consulta::class);
    }

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }

    public function psicologo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'psicologo_id');
    }
}