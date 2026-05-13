<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_orden')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->string('estado')->default('pendiente');
            $table->string('metodo_pago')->nullable();
            $table->string('referencia_pago')->nullable();
            $table->string('comprobante_pago')->nullable();
            $table->text('notas_cliente')->nullable();
            $table->text('notas_empresa')->nullable();
            $table->string('tipo_entrega')->nullable();
            $table->text('direccion_entrega')->nullable();
            $table->string('ciudad_entrega')->nullable();
            $table->string('municipio_entrega')->nullable();
            $table->text('referencia_entrega')->nullable();
            $table->string('telefono_contacto')->nullable();
            $table->timestamp('pagado_at')->nullable();
            $table->timestamp('confirmado_at')->nullable();
            $table->timestamp('completado_at')->nullable();
            $table->timestamp('cancelado_at')->nullable();
            $table->timestamps();
        });

        Schema::create('orden_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_id')->constrained('ordenes')->cascadeOnDelete();
            $table->string('tipo')->nullable();
            $table->foreignId('servicio_id')->nullable()->constrained('servicios')->nullOnDelete();
            $table->foreignId('producto_id')->nullable()->constrained('productos')->nullOnDelete();
            $table->string('nombre_servicio')->nullable();
            $table->text('descripcion_servicio')->nullable();
            $table->decimal('precio', 10, 2)->default(0);
            $table->integer('cantidad')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orden_items');
        Schema::dropIfExists('ordenes');
    }
};
