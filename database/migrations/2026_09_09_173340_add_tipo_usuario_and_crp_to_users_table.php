<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // paciente | psicologo
            $table->enum('tipo_usuario', ['paciente', 'psicologo'])->after('email');
            $table->string('crp', 9)->nullable()->unique()->after('tipo_usuario');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tipo_usuario', 'crp']);
        });
    }
};
