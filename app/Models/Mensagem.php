<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mensagem extends Model
{
    use HasFactory;

    public $table = "mensagens";

    protected $fillable = [
        'remetente_id',
        'destinatario_id',
        'mensagem',
        'lida_em',
    ];

    protected function casts(): array
    {
        return [
            'lida_em' => 'datetime',
        ];
    }

    public function remetente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'remetente_id');
    }

    public function destinatario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'destinatario_id');
    }
}
