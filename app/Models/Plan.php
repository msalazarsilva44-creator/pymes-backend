<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $table = 'planes';

    protected $fillable = [
        'nombre',
        'slug',
        'precio_mensual',
        'precio_anual',
        'posicion_prioridad',
        'max_fotos',
        'panel_metricas',
        'notificaciones_push',
        'verificacion_perfil',
        'descripcion',
        'activo',
        'caracteristicas',
        'color_badge',
        'destacado',
        'orden',
    ];

    protected $casts = [
        'precio_mensual' => 'decimal:2',
        'precio_anual' => 'decimal:2',
        'panel_metricas' => 'boolean',
        'notificaciones_push' => 'boolean',
        'verificacion_perfil' => 'boolean',
        'activo' => 'boolean',
        'caracteristicas' => 'array',
        'destacado' => 'boolean',
    ];

    /**
     * Empresas con este plan
     */
    public function empresas()
    {
        return $this->hasMany(Empresa::class);
    }

    /**
     * Suscripciones de este plan
     */
    public function suscripciones()
    {
        return $this->hasMany(Suscripcion::class);
    }

    /**
     * Verificar si es plan gratis
     */
    public function isGratis()
    {
        return $this->slug === 'gratis';
    }

    /**
     * Verificar si es plan básico
     */
    public function isBasico()
    {
        return $this->slug === 'basico';
    }

    /**
     * Verificar si es plan premium
     */
    public function isPremium()
    {
        return $this->slug === 'premium';
    }
}

