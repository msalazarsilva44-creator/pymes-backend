<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->decimal('precio_mensual', 10, 2)->default(0);
            $table->decimal('precio_anual', 10, 2)->default(0);
            $table->integer('posicion_prioridad')->default(0);
            $table->integer('max_fotos')->default(3);
            $table->boolean('panel_metricas')->default(false);
            $table->boolean('notificaciones_push')->default(false);
            $table->boolean('verificacion_perfil')->default(false);
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planes');
    }
};
