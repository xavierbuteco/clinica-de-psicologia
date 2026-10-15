<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Os atributos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo_usuario',
        'crp',
    ];

    /**
     * Os atributos ocultos na serialização.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Mapeamento de casts de atributos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Verifica se o usuário possui o perfil de psicólogo.
     */
    public function ehPsicologo(): bool
    {
        return $this->tipo_usuario === 'psicologo';
    }

    /**
     * Relacionamento das consultas onde este usuário é o paciente.
     */
    public function consultasComoPaciente(): HasMany
    {
        return $this->hasMany(Consulta::class, 'paciente_id');
    }

    /**
     * Relacionamento das consultas onde este usuário é o psicólogo.
     */
    public function consultasComoPsicologo(): HasMany
    {
        return $this->hasMany(Consulta::class, 'psicologo_id');
    }

    /**
     * Feedbacks associados ao usuário como paciente.
     */
    public function feedbacksComoPaciente(): HasMany
    {
        return $this->hasMany(Feedback::class, 'paciente_id');
    }

    /**
     * Feedbacks associados ao usuário como psicólogo.
     */
    public function feedbacksComoPsicologo(): HasMany
    {
        return $this->hasMany(Feedback::class, 'psicologo_id');
    }

    /**
     * Alias para feedbacks recebidos pelo paciente.
     */
    public function feedbacksRecebidos(): HasMany
    {
        return $this->feedbacksComoPaciente();
    }

    /**
     * Pacientes únicos vinculados às consultas deste psicólogo.
     *
     * @return Builder
     */
    public function pacientesVinculados(): Builder
    {
        return self::whereIn('id', function ($query) {
            $query->select('paciente_id')
                ->from('consultas')
                ->where('psicologo_id', $this->id)
                ->distinct();
        })->where('tipo_usuario', 'paciente');
    }
}