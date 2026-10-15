<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // No Postgres, Consulta::enum() vira um CHECK constraint (não um
        // tipo ENUM nativo), então para adicionar novos valores precisamos
        // recriar esse constraint.
        DB::statement('ALTER TABLE consultas DROP CONSTRAINT IF EXISTS consultas_status_check');

        DB::statement("
            ALTER TABLE consultas
            ADD CONSTRAINT consultas_status_check
            CHECK (status IN ('pendente', 'confirmada', 'concluida', 'cancelada'))
        ");

        DB::statement("ALTER TABLE consultas ALTER COLUMN status SET DEFAULT 'pendente'");
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE consultas DROP CONSTRAINT IF EXISTS consultas_status_check');

        DB::statement("
            ALTER TABLE consultas
            ADD CONSTRAINT consultas_status_check
            CHECK (status IN ('agendada', 'concluida', 'cancelada'))
        ");

        DB::statement("ALTER TABLE consultas ALTER COLUMN status SET DEFAULT 'agendada'");
    }
};
