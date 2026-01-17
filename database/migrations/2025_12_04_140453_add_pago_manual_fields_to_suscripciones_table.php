<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Optimizado para MySQL con soporte ENUM
     */
    public function up(): void
    {
        // Detectar si es MySQL o SQLite
        $driver = Schema::getConnection()->getDriverName();
        
        if ($driver === 'mysql') {
            // MySQL: Modificar ENUM del campo estado
            DB::statement("ALTER TABLE suscripciones MODIFY COLUMN estado 
                ENUM('activa', 'cancelada', 'vencida', 'pendiente_pago', 'pendiente_aprobacion', 'rechazada') 
                DEFAULT 'pendiente_aprobacion'");
        }
        
        // Agregar campos (compatible con ambos)
        Schema::table('suscripciones', function (Blueprint $table) {
            // Información de pago manual
            $table->string('capture_pago')->nullable()->after('pagado_at'); // Path de la imagen del pago
            $table->string('referencia_bancaria', 10)->nullable()->after('capture_pago'); // Últimos 4 dígitos
            $table->date('fecha_pago')->nullable()->after('referencia_bancaria'); // Fecha del pago
            $table->string('nombre_empresa_pagadora')->nullable()->after('fecha_pago'); // Nombre del pagador
            $table->string('rif_pagador', 20)->nullable()->after('nombre_empresa_pagadora'); // RIF del pagador
            
            // Información de aprobación
            $table->unsignedBigInteger('aprobada_por')->nullable()->after('rif_pagador'); // Admin que aprobó
            $table->timestamp('aprobada_at')->nullable()->after('aprobada_por'); // Timestamp de aprobación
            $table->text('motivo_rechazo')->nullable()->after('aprobada_at'); // Motivo de rechazo
            
            // Foreign key
            $table->foreign('aprobada_por')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suscripciones', function (Blueprint $table) {
            $table->dropForeign(['aprobada_por']);
            $table->dropColumn([
                'capture_pago',
                'referencia_bancaria',
                'fecha_pago',
                'nombre_empresa_pagadora',
                'rif_pagador',
                'aprobada_por',
                'aprobada_at',
                'motivo_rechazo'
            ]);
        });
        
        // Revertir ENUM en MySQL
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE suscripciones MODIFY COLUMN estado 
                ENUM('activa', 'cancelada', 'vencida', 'pendiente_pago') 
                DEFAULT 'activa'");
        }
    }
};

