<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metrica extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'user_id',
        'tipo',
        'fecha',
        'ip',
        'user_agent',
        'origen',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    /**
     * Empresa de la métrica
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Usuario que generó la métrica (si estaba autenticado)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope por tipo
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Scope por rango de fechas
     */
    public function scopePorFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
    }
}

