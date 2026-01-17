<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('empresas', function (Blueprint $table) {
            // El campo rfc ya existe pero vamos a asegurarnos de que tenga un índice
            $table->string('rfc')->nullable()->change();
        });
    }

    public function down(): void
    {
        //
    }
};

