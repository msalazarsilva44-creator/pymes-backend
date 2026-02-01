<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPagoEmpresa extends Model
{
    use HasFactory;

    protected $table = 'metodos_pago_empresa';

    protected $fillable = [
        'empresa_id',
        'tipo',
        'activo',
        // PayPal
        'paypal_email',
        // Binance
        'binance_email',
        'binance_id',
        // Transferencia Bancaria
        'banco_nombre',
        'banco_cuenta',
        'banco_titular',
        'banco_cedula',
        'banco_tipo_cuenta',
        // Pago Móvil
        'pago_movil_banco',
        'pago_movil_cedula',
        'pago_movil_telefono',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Empresa dueña de este método de pago
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Obtener los datos formateados del método de pago
     */
    public function getDatosFormateadosAttribute()
    {
        return match($this->tipo) {
            'paypal' => [
                'tipo' => 'PayPal',
                'icono' => '💳',
                'info' => $this->paypal_email,
            ],
            'binance' => [
                'tipo' => 'Binance (USDT)',
                'icono' => '🪙',
                'info' => $this->binance_email ?: $this->binance_id,
            ],
            'transferencia' => [
                'tipo' => 'Transferencia Bancaria',
                'icono' => '🏦',
                'banco' => $this->banco_nombre,
                'cuenta' => $this->banco_cuenta,
                'titular' => $this->banco_titular,
                'cedula' => $this->banco_cedula,
                'tipo_cuenta' => $this->banco_tipo_cuenta,
            ],
            'pago_movil' => [
                'tipo' => 'Pago Móvil',
                'icono' => '📱',
                'banco' => $this->pago_movil_banco,
                'cedula' => $this->pago_movil_cedula,
                'telefono' => $this->pago_movil_telefono,
            ],
            default => [],
        };
    }

    /**
     * Obtener el nombre legible del tipo
     */
    public function getTipoNombreAttribute()
    {
        return match($this->tipo) {
            'paypal' => 'PayPal',
            'binance' => 'Binance (USDT)',
            'transferencia' => 'Transferencia Bancaria',
            'pago_movil' => 'Pago Móvil',
            default => $this->tipo,
        };
    }

    /**
     * Scope para métodos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
