<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resenas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->integer('calificacion');
            $table->text('comentario')->nullable();
            $table->text('respuesta_empresa')->nullable();
            $table->timestamp('respondida_at')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('fotos_empresa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->string('url');
            $table->string('titulo')->nullable();
            $table->integer('orden')->default(0);
            $table->timestamps();
        });

        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->string('dia');
            $table->time('hora_apertura')->nullable();
            $table->time('hora_cierre')->nullable();
            $table->boolean('cerrado')->default(false);
            $table->timestamps();
        });

        Schema::create('metricas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->string('tipo');
            $table->string('fuente')->nullable();
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('tipo');
            $table->string('titulo');
            $table->text('mensaje')->nullable();
            $table->json('data')->nullable();
            $table->timestamp('leida_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('metricas');
        Schema::dropIfExists('horarios');
        Schema::dropIfExists('fotos_empresa');
        Schema::dropIfExists('resenas');
    }
};
