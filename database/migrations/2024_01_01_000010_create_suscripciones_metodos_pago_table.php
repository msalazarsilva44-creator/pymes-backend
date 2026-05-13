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
            $table->boolean('activo')->default(true);
            // PayPal
            $table->string('paypal_email')->nullable();
            // Binance
            $table->string('binance_email')->nullable();
            $table->string('binance_id')->nullable();
            // Transferencia bancaria
            $table->string('banco_nombre')->nullable();
            $table->string('banco_cuenta')->nullable();
            $table->string('banco_titular')->nullable();
            $table->string('banco_cedula')->nullable();
            $table->string('banco_tipo_cuenta')->nullable();
            // Pago Móvil
            $table->string('pago_movil_banco')->nullable();
            $table->string('pago_movil_cedula')->nullable();
            $table->string('pago_movil_telefono')->nullable();
            $table->timestamps();
        });

        Schema::create('carrito', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('empresa_id')->nullable()->constrained('empresas')->nullOnDelete();
            $table->foreignId('servicio_id')->nullable()->constrained('servicios')->nullOnDelete();
            $table->foreignId('producto_id')->nullable()->constrained('productos')->nullOnDelete();
            $table->string('tipo')->nullable();
            $table->decimal('precio', 10, 2)->default(0);
            $table->integer('cantidad')->default(1);
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
        Schema::dropIfExists('carrito');
        Schema::dropIfExists('inventario_movimientos');
        Schema::dropIfExists('metodos_pago_empresa');
        Schema::dropIfExists('suscripciones');
    }
};
