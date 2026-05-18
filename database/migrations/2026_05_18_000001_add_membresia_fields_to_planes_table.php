<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('planes', function (Blueprint $table) {
            $table->json('caracteristicas')->nullable()->after('descripcion');
            $table->string('color_badge', 20)->default('blue')->after('caracteristicas');
            $table->boolean('destacado')->default(false)->after('color_badge');
            $table->integer('orden')->default(0)->after('destacado');
        });
    }

    public function down(): void
    {
        Schema::table('planes', function (Blueprint $table) {
            $table->dropColumn(['caracteristicas', 'color_badge', 'destacado', 'orden']);
        });
    }
};
