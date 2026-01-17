<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Suscripcion extends Model
{
    use HasFactory;

    protected $table = 'suscripciones';

    protected $fillable = [
        'empresa_id',
        'plan_id',
        'tipo_periodo',
        'precio_pagado',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'metodo_pago',
        'transaccion_id',
        'pagado_at',
        'renovacion_automatica',
        'capture_pago',
        'referencia_bancaria',
        'fecha_pago',
        'nombre_empresa_pagadora',
        'rif_pagador',
        'aprobada_por',
        'aprobada_at',
        'motivo_rechazo',
    ];

    protected $casts = [
        'precio_pagado' => 'decimal:2',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'fecha_pago' => 'date',
        'pagado_at' => 'datetime',
        'aprobada_at' => 'datetime',
        'renovacion_automatica' => 'boolean',
    ];

    /**
     * Empresa suscrita
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Plan contratado
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Scope para suscripciones activas
     */
    public function scopeActivas($query)
    {
        return $query->where('estado', 'activa')
            ->where('fecha_fin', '>=', now());
    }

    /**
     * Verificar si está vencida
     */
    public function isVencida()
    {
        return $this->fecha_fin < now();
    }

    /**
     * Verificar si está activa
     */
    public function isActiva()
    {
        return $this->estado === 'activa' && !$this->isVencida();
    }

    /**
     * Scope para suscripciones pendientes de aprobación
     */
    public function scopePendientesAprobacion($query)
    {
        return $query->where('estado', 'pendiente_aprobacion')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Admin que aprobó la suscripción
     */
    public function aprobadaPor()
    {
        return $this->belongsTo(User::class, 'aprobada_por');
    }

    /**
     * Verificar si está pendiente de aprobación
     */
    public function isPendienteAprobacion()
    {
        return $this->estado === 'pendiente_aprobacion';
    }

    /**
     * Verificar si fue rechazada
     */
    public function isRechazada()
    {
        return $this->estado === 'rechazada';
    }

    /**
     * Obtener días restantes de la suscripción
     */
    public function diasRestantes()
    {
        if (!$this->fecha_fin || !$this->isActiva()) {
            return 0;
        }

        $dias = now()->diffInDays($this->fecha_fin, false);
        return $dias > 0 ? (int)$dias : 0;
    }

    /**
     * Verificar si está por vencer (menos de 7 días)
     */
    public function estaPorVencer()
    {
        $dias = $this->diasRestantes();
        return $dias > 0 && $dias <= 7;
    }

    /**
     * Verificar si está por vencer urgente (menos de 3 días)
     */
    public function venceUrgente()
    {
        $dias = $this->diasRestantes();
        return $dias > 0 && $dias <= 3;
    }
}

