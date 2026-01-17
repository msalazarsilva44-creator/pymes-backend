<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Ampliar el campo referencia_bancaria de 10 a 50 caracteres
     * para soportar Transaction IDs de PayPal, Binance, Zelle
     */
    public function up(): void
    {
        // Usar DB statement directo para MySQL
        DB::statement('ALTER TABLE suscripciones MODIFY referencia_bancaria VARCHAR(50) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir a 10 caracteres
        DB::statement('ALTER TABLE suscripciones MODIFY referencia_bancaria VARCHAR(10) NULL');
    }
};
