<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->foreignId('ciudad_id')->constrained('ciudades')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('planes')->onDelete('cascade');
            
            // Información básica
            $table->string('nombre_comercial');
            $table->string('razon_social')->nullable();
            $table->string('rfc')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('logo')->nullable();
            
            // Contacto
            $table->string('telefono');
            $table->string('email_contacto');
            $table->string('whatsapp')->nullable();
            $table->string('sitio_web')->nullable();
            
            // Ubicación
            $table->text('direccion');
            $table->string('colonia')->nullable();
            $table->string('codigo_postal')->nullable();
            $table->decimal('latitud', 10, 7)->nullable();
            $table->decimal('longitud', 10, 7)->nullable();
            
            // Verificación
            $table->boolean('verificado')->default(false);
            $table->timestamp('verificado_at')->nullable();
            $table->string('documento_verificacion')->nullable();
            
            // Estadísticas
            $table->decimal('calificacion_promedio', 3, 2)->default(0);
            $table->integer('total_resenas')->default(0);
            $table->integer('total_vistas')->default(0);
            $table->integer('total_clics')->default(0);
            
            // Estado
            $table->boolean('activo')->default(true);
            $table->text('motivo_suspension')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para mejor rendimiento en MySQL
            $table->index('activo');
            $table->index('verificado');
            $table->index('calificacion_promedio');
            $table->index(['categoria_id', 'ciudad_id', 'activo']);
            $table->index(['plan_id', 'activo']);
            
            // Índice de texto completo para búsquedas (solo MySQL)
            if (Schema::getConnection()->getDriverName() === 'mysql') {
                $table->fullText(['nombre_comercial', 'descripcion']);
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};

