<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('metricas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            
            $table->enum('tipo', ['vista', 'clic_telefono', 'clic_whatsapp', 'clic_sitio_web', 'clic_direccion']);
            $table->date('fecha');
            $table->ipAddress('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('origen')->nullable(); // web, mobile, desktop-app
            
            $table->timestamps();
            
            // Índice para consultas rápidas por fecha
            $table->index(['empresa_id', 'fecha', 'tipo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('metricas');
    }
};

