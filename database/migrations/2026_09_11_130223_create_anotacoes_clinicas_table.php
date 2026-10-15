<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anotacoes_clinicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('psicologo_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('consulta_id')->nullable()->constrained('consultas')->nullOnDelete();
            $table->text('conteudo');
            $table->timestamps();

            $table->index(['paciente_id', 'psicologo_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anotacoes_clinicas');
    }
};
