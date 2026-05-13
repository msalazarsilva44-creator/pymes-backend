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
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('planes')->cascadeOnDelete();
            $table->string('tipo_periodo')->default('mensual');
            $table->decimal('precio_pagado', 10, 2)->default(0);
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->string('estado')->default('pendiente_aprobacion');
            $table->string('metodo_pago')->nullable();
            $table->string('transaccion_id')->nullable();
            $table->timestamp('pagado_at')->nullable();
            $table->boolean('renovacion_automatica')->default(false);
            $table->string('capture_pago')->nullable();
            $table->string('referencia_bancaria')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->string('nombre_empresa_pagadora')->nullable();
            $table->string('rif_pagador')->nullable();
            $table->foreignId('aprobada_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('aprobada_at')->nullable();
            $table->text('motivo_rechazo')->nullable();
            $table->timestamps();
        });

        Schema::create('metodos_pago_empresa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->string('tipo');
            $table->string('nombre_titular')->nullable();
            $table->string('numero_cuenta')->nullable();
            $table->string('banco')->nullable();
            $table->string('cedula_rif')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('inventario_movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->string('tipo');
            $table->integer('cantidad');
            $table->integer('stock_anterior')->nullable();
            $table->integer('stock_nuevo')->nullable();
            $table->text('motivo')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventario_movimientos');
        Schema::dropIfExists('metodos_pago_empresa');
        Schema::dropIfExists('suscripciones');
    }
};
