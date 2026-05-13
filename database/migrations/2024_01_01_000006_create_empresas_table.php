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
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->nullOnDelete();
            $table->foreignId('ciudad_id')->nullable()->constrained('ciudades')->nullOnDelete();
            $table->foreignId('municipio_id')->nullable()->constrained('municipios')->nullOnDelete();
            $table->foreignId('plan_id')->nullable()->constrained('planes')->nullOnDelete();
            $table->string('nombre_comercial');
            $table->string('razon_social')->nullable();
            $table->string('rfc')->nullable();
            $table->string('documento_rif')->nullable();
            $table->text('descripcion')->nullable();
            $table->boolean('ofrece_productos')->default(false);
            $table->boolean('ofrece_servicios')->default(false);
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email_contacto')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('sitio_web')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();
            $table->text('direccion')->nullable();
            $table->string('colonia')->nullable();
            $table->string('codigo_postal')->nullable();
            $table->decimal('latitud', 10, 7)->nullable();
            $table->decimal('longitud', 10, 7)->nullable();
            $table->boolean('activo')->default(true);
            $table->boolean('verificado')->default(false);
            $table->timestamp('verificado_at')->nullable();
            $table->string('documento_verificacion')->nullable();
            $table->decimal('calificacion_promedio', 3, 2)->default(0);
            $table->integer('total_resenas')->default(0);
            $table->integer('total_vistas')->default(0);
            $table->integer('total_clics')->default(0);
            $table->text('motivo_suspension')->nullable();
            $table->boolean('aprobado')->default(false);
            $table->timestamp('aprobado_at')->nullable();
            $table->foreignId('aprobado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->text('motivo_rechazo')->nullable();
            $table->timestamp('boost_hasta')->nullable();
            $table->boolean('penalizada')->default(false);
            $table->text('motivo_penalizacion')->nullable();
            $table->timestamp('penalizada_at')->nullable();
            $table->foreignId('penalizada_por')->nullable()->constrained('users')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
