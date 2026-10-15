<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('psicologo_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('data');
            $table->time('hora');
            $table->string('tipo_consulta'); // ex: primeira_consulta, retorno, avaliacao, emergencial
            $table->string('laudo_path')->nullable();
            $table->text('observacoes')->nullable();
            $table->enum('status', ['agendada', 'concluida', 'cancelada'])->default('agendada');
            $table->timestamps();

            $table->index(['paciente_id', 'data']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
