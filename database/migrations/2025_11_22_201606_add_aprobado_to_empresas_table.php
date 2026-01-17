<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->boolean('aprobado')->default(false)->after('activo');
            $table->timestamp('aprobado_at')->nullable()->after('aprobado');
            $table->unsignedBigInteger('aprobado_por')->nullable()->after('aprobado_at');
            $table->text('motivo_rechazo')->nullable()->after('aprobado_por');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->dropColumn(['aprobado', 'aprobado_at', 'aprobado_por', 'motivo_rechazo']);
        });
    }
};
