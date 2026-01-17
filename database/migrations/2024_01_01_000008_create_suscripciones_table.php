<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suscripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('planes')->onDelete('cascade');
            
            $table->enum('tipo_periodo', ['mensual', 'anual']);
            $table->decimal('precio_pagado', 8, 2);
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->enum('estado', ['activa', 'cancelada', 'vencida', 'pendiente_pago'])->default('activa');
            
            // Información de pago
            $table->string('metodo_pago')->nullable(); // stripe, paypal, transferencia
            $table->string('transaccion_id')->nullable();
            $table->timestamp('pagado_at')->nullable();
            
            // Renovación automática
            $table->boolean('renovacion_automatica')->default(false);
            
            $table->timestamps();
            
            // Índices para mejor rendimiento en MySQL
            $table->index('estado');
            $table->index('fecha_fin');
            $table->index(['empresa_id', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suscripciones');
    }
};

