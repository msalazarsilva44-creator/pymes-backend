<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

    protected $table = 'ordenes';

    protected $fillable = [
        'numero_orden',
        'user_id',
        'empresa_id',
        'subtotal',
        'total',
        'estado',
        'metodo_pago',
        'referencia_pago',
        'comprobante_pago',
        'notas_cliente',
        'notas_empresa',
        'tipo_entrega',
        'direccion_entrega',
        'ciudad_entrega',
        'municipio_entrega',
        'referencia_entrega',
        'telefono_contacto',
        'pagado_at',
        'confirmado_at',
        'completado_at',
        'cancelado_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
        'pagado_at' => 'datetime',
        'confirmado_at' => 'datetime',
        'completado_at' => 'datetime',
        'cancelado_at' => 'datetime',
    ];

    /**
     * Usuario que realizó la orden
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Empresa a la que pertenece la orden
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Items de la orden
     */
    public function items()
    {
        return $this->hasMany(OrdenItem::class);
    }

    /**
     * Generar número de orden único
     */
    public static function generarNumeroOrden()
    {
        $prefix = 'ORD';
        $date = now()->format('ymd');
        $random = strtoupper(substr(uniqid(), -4));
        return "{$prefix}-{$date}-{$random}";
    }

    /**
     * Scope para órdenes pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Scope para órdenes pagadas
     */
    public function scopePagadas($query)
    {
        return $query->where('estado', 'pagado');
    }

    /**
     * Scope para órdenes confirmadas
     */
    public function scopeConfirmadas($query)
    {
        return $query->where('estado', 'confirmado');
    }

    /**
     * Scope para órdenes completadas
     */
    public function scopeCompletadas($query)
    {
        return $query->where('estado', 'completado');
    }

    /**
     * Verificar si la orden está pendiente
     */
    public function isPendiente()
    {
        return $this->estado === 'pendiente';
    }

    /**
     * Verificar si la orden está pagada
     */
    public function isPagado()
    {
        return $this->estado === 'pagado';
    }

    /**
     * Verificar si la orden está confirmada
     */
    public function isConfirmado()
    {
        return $this->estado === 'confirmado';
    }

    /**
     * Verificar si la orden está completada
     */
    public function isCompletado()
    {
        return $this->estado === 'completado';
    }

    /**
     * Obtener el color del estado para UI
     */
    public function getEstadoColorAttribute()
    {
        return match($this->estado) {
            'pendiente' => 'yellow',
            'pagado' => 'blue',
            'confirmado' => 'cyan',
            'completado' => 'green',
            'cancelado' => 'red',
            'reembolsado' => 'gray',
            default => 'gray',
        };
    }

    /**
     * Obtener el label del estado para UI
     */
    public function getEstadoLabelAttribute()
    {
        return match($this->estado) {
            'pendiente' => 'Pendiente',
            'pagado' => 'Pagado',
            'confirmado' => 'Confirmado',
            'completado' => 'Completado',
            'cancelado' => 'Cancelado',
            'reembolsado' => 'Reembolsado',
            default => $this->estado,
        };
    }
}
