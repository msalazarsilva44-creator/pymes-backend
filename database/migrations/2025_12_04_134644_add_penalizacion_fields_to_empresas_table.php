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
            $table->boolean('penalizada')->default(false)->after('aprobado');
            $table->text('motivo_penalizacion')->nullable()->after('penalizada');
            $table->timestamp('penalizada_at')->nullable()->after('motivo_penalizacion');
            $table->unsignedBigInteger('penalizada_por')->nullable()->after('penalizada_at');
            
            // Foreign key para el admin que penalizó
            $table->foreign('penalizada_por')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->dropForeign(['penalizada_por']);
            $table->dropColumn(['penalizada', 'motivo_penalizacion', 'penalizada_at', 'penalizada_por']);
        });
    }
};
