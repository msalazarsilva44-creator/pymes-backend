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
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->integer('calificacion'); // 1-5 estrellas
            $table->text('comentario')->nullable();
            $table->text('respuesta_empresa')->nullable();
            $table->timestamp('respondido_at')->nullable();
            
            $table->boolean('verificada')->default(false); // Cliente verificado que usó el servicio
            $table->boolean('visible')->default(true);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resenas');
    }
};

