<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ciudades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('estado')->nullable();
            $table->string('pais')->default('Venezuela');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('municipios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ciudad_id')->constrained('ciudades')->cascadeOnDelete();
            $table->string('nombre');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('ciudad_id')->references('id')->on('ciudades')->nullOnDelete();
            $table->foreign('municipio_id')->references('id')->on('municipios')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['ciudad_id']);
            $table->dropForeign(['municipio_id']);
        });
        Schema::dropIfExists('municipios');
        Schema::dropIfExists('ciudades');
    }
};
