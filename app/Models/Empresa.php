<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'categoria_id',
        'ciudad_id',
        'municipio_id',
        'plan_id',
        'nombre_comercial',
        'razon_social',
        'rfc',
        'documento_rif',
        'descripcion',
        'ofrece_productos',
        'ofrece_servicios',
        'logo',
        'banner',
        'telefono',
        'email_contacto',
        'whatsapp',
        'sitio_web',
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'youtube',
        'tiktok',
        'direccion',
        'colonia',
        'codigo_postal',
        'latitud',
        'longitud',
        'activo',
        'verificado',
        'verificado_at',
        'documento_verificacion',
        'calificacion_promedio',
        'total_resenas',
        'total_vistas',
        'total_clics',
        'motivo_suspension',
        'aprobado',
        'aprobado_at',
        'aprobado_por',
        'motivo_rechazo',
        'boost_hasta',
        'penalizada',
        'motivo_penalizacion',
        'penalizada_at',
        'penalizada_por',
    ];

    protected $casts = [
        'latitud' => 'decimal:7',
        'longitud' => 'decimal:7',
        'verificado' => 'boolean',
        'verificado_at' => 'datetime',
        'calificacion_promedio' => 'decimal:2',
        'activo' => 'boolean',
        'aprobado' => 'boolean',
        'aprobado_at' => 'datetime',
        'boost_hasta' => 'datetime',
        'penalizada' => 'boolean',
        'penalizada_at' => 'datetime',
        'ofrece_productos' => 'boolean',
        'ofrece_servicios' => 'boolean',
    ];

    /**
     * Atributos calculados a incluir en la serialización JSON.
     */
    protected $appends = ['status', 'modules'];

    /**
     * Usuario propietario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Categoría de la empresa
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Ciudad donde opera
     */
    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class);
    }

    /**
     * Municipio donde opera
     */
    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

    /**
     * Plan actual
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Suscripciones de la empresa
     */
    public function suscripciones()
    {
        return $this->hasMany(Suscripcion::class);
    }

    /**
     * Métodos de pago de la empresa
     */
    public function metodosPago()
    {
        return $this->hasMany(MetodoPagoEmpresa::class);
    }

    /**
     * Órdenes recibidas
     */
    public function ordenes()
    {
        return $this->hasMany(Orden::class);
    }

    /**
     * Suscripción activa actual
     */
    public function suscripcionActiva()
    {
        return $this->hasOne(Suscripcion::class)
            ->where('estado', 'activa')
            ->where('fecha_fin', '>=', now())
            ->latest();
    }

    /**
     * Última suscripción registrada (cualquier estado)
     */
    public function ultimaSuscripcion()
    {
        return $this->hasOne(Suscripcion::class)->latest();
    }

    /**
     * Datos normalizados del plan para panel administrativo
     */
    public function resolvePlanPanel(): array
    {
        $default = [
            'nombre' => 'Sin plan',
            'slug' => null,
            'color_badge' => 'slate',
            'estado_suscripcion' => 'sin_plan',
        ];

        $planModel = $this->plan ?: optional($this->ultimaSuscripcion)->plan;

        if (!$planModel) {
            return $default;
        }

        $color = $planModel->color_badge ?? 'slate';
        $allowedColors = ['blue', 'violet', 'emerald', 'amber', 'rose', 'slate'];
        if (!in_array($color, $allowedColors, true)) {
            $color = 'slate';
        }

        $estado = 'sin_plan';
        $now = now();

        if ($this->relationLoaded('suscripcionActiva') && $this->suscripcionActiva) {
            $activa = $this->suscripcionActiva;
            $estado = ($activa->fecha_fin && $activa->fecha_fin->lt($now)) ? 'vencida' : 'activa';
        } elseif ($this->relationLoaded('ultimaSuscripcion') && $this->ultimaSuscripcion) {
            $ultima = $this->ultimaSuscripcion;

            if ($ultima->estado === 'activa') {
                $estado = ($ultima->fecha_fin && $ultima->fecha_fin->lt($now)) ? 'vencida' : 'activa';
            } elseif ($ultima->estado === 'pendiente_aprobacion') {
                $estado = 'en_revision';
            } elseif ($ultima->estado === 'pendiente_pago') {
                $estado = 'pendiente_pago';
            } elseif ($ultima->estado === 'rechazada') {
                $estado = 'sin_plan';
            }
        }

        return [
            'nombre' => $planModel->nombre ?? 'Sin plan',
            'slug' => $planModel->slug ?? null,
            'color_badge' => $color,
            'estado_suscripcion' => $estado,
        ];
    }

    /**
     * Obtener días restantes de suscripción
     */
    public function diasRestantesSuscripcion()
    {
        $suscripcion = $this->suscripcionActiva;
        if (!$suscripcion) return 0;
        
        return $suscripcion->diasRestantes();
    }

    /**
     * Verificar si tiene plan pago activo
     */
    public function tienePlanPagoActivo()
    {
        return $this->tienePlanPago() && $this->suscripcionActiva()->exists();
    }

    /**
     * Fotos de la empresa
     */
    public function fotos()
    {
        return $this->hasMany(FotoEmpresa::class);
    }

    /**
     * Servicios ofrecidos
     */
    public function servicios()
    {
        return $this->hasMany(Servicio::class);
    }

    /**
     * Productos físicos / con stock
     */
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    /**
     * Horarios
     */
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    /**
     * Reseñas recibidas
     */
    public function resenas()
    {
        return $this->hasMany(Resena::class);
    }


    /**
     * Métricas
     */
    public function metricas()
    {
        return $this->hasMany(Metrica::class);
    }

    /**
     * Scope para empresas activas
     */
    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para empresas verificadas
     */
    public function scopeVerificadas($query)
    {
        return $query->where('verificado', true);
    }

    /**
     * Scope para buscar por ciudad
     */
    public function scopePorCiudad($query, $ciudadId)
    {
        return $query->where('ciudad_id', $ciudadId);
    }

    /**
     * Scope para buscar por categoría
     */
    public function scopePorCategoria($query, $categoriaId)
    {
        return $query->where('categoria_id', $categoriaId);
    }

    /**
     * Scope para empresas aprobadas
     */
    public function scopeAprobadas($query)
    {
        return $query->where('aprobado', true);
    }

    /**
     * Scope para empresas pendientes de aprobación
     */
    public function scopePendientes($query)
    {
        return $query->where('aprobado', false);
    }

    /**
     * Scope ordenado por plan (posicionamiento)
     * Primero boost activos, luego premium por calificación, luego básico, luego gratis
     */
    public function scopeOrdenadoPorPlan($query)
    {
        return $query->join('planes', 'empresas.plan_id', '=', 'planes.id')
            ->selectRaw('empresas.*, 
                CASE 
                    WHEN empresas.boost_hasta IS NOT NULL AND empresas.boost_hasta >= NOW() THEN 1000
                    ELSE planes.posicion_prioridad 
                END as prioridad_final')
            ->orderBy('prioridad_final', 'desc')
            ->orderBy('empresas.calificacion_promedio', 'desc')
            ->select('empresas.*');
    }

    /**
     * Verificar si tiene boost activo
     */
    public function tieneBoostActivo()
    {
        return $this->boost_hasta && $this->boost_hasta->isFuture();
    }

    /**
     * Activar boost de 2 días (para plan básico)
     */
    public function activarBoost()
    {
        $this->update([
            'boost_hasta' => now()->addDays(2)
        ]);
    }

    /**
     * Verificar si tiene acceso al panel de métricas
     */
    public function tieneAccesoMetricas()
    {
        return $this->plan && $this->plan->panel_metricas;
    }

    /**
     * Verificar si tiene acceso a notificaciones
     */
    public function tieneAccesoNotificaciones()
    {
        return $this->plan && $this->plan->notificaciones_push;
    }

    /**
     * Verificar si es plan gratis
     */
    public function esPlanGratis()
    {
        return $this->plan && $this->plan->slug === 'gratis';
    }

    /**
     * Verificar si es plan básico
     */
    public function esPlanBasico()
    {
        return $this->plan && $this->plan->slug === 'basico';
    }

    /**
     * Verificar si es plan premium
     */
    public function esPlanPremium()
    {
        return $this->plan && $this->plan->slug === 'premium';
    }

    /**
     * Verificar si está penalizada
     */
    public function estaPenalizada()
    {
        return $this->penalizada === true;
    }

    /**
     * Verificar si tiene plan de pago activo
     */
    public function tienePlanPago()
    {
        return $this->plan && in_array($this->plan->slug, ['basico', 'premium']);
    }

    /**
     * Obtener el estado visual de la empresa
     */
    public function getEstadoAttribute()
    {
        if ($this->penalizada) {
            return 'Penalizada';
        }
        if (!$this->aprobado) {
            return 'Pendiente';
        }
        if (!$this->activo) {
            return 'Inactiva';
        }
        return 'Activa';
    }

    /**
     * Status normalizado para el frontend: 'pendiente' | 'aprobado' | 'rechazado'.
     * Derivado de los flags `aprobado` y `motivo_rechazo`.
     */
    public function getStatusAttribute(): string
    {
        if ($this->aprobado) {
            return 'aprobado';
        }
        if (!empty($this->motivo_rechazo)) {
            return 'rechazado';
        }
        return 'pendiente';
    }

    /**
     * Módulos disponibles para esta empresa.
     * Derivado de los flags `ofrece_productos` y `ofrece_servicios`.
     */
    public function getModulesAttribute(): array
    {
        return [
            'products' => (bool) $this->ofrece_productos,
            'services' => (bool) $this->ofrece_servicios,
        ];
    }

    /**
     * Scope para empresas no penalizadas
     */
    public function scopeNoPenalizadas($query)
    {
        return $query->where('penalizada', false);
    }

    /**
     * Scope para empresas penalizadas
     */
    public function scopePenalizadas($query)
    {
        return $query->where('penalizada', true);
    }
}

