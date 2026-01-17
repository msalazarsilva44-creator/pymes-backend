<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Hacer nullable los campos fecha_inicio y fecha_fin
     * ya que solo se llenan cuando el admin aprueba la suscripción
     */
    public function up(): void
    {
        // Usar DB statement directo para MySQL
        DB::statement('ALTER TABLE suscripciones MODIFY fecha_inicio DATE NULL');
        DB::statement('ALTER TABLE suscripciones MODIFY fecha_fin DATE NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir a NOT NULL (solo si no hay registros con NULL)
        DB::statement('ALTER TABLE suscripciones MODIFY fecha_inicio DATE NOT NULL');
        DB::statement('ALTER TABLE suscripciones MODIFY fecha_fin DATE NOT NULL');
    }
};
