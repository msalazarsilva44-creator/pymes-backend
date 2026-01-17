<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'tipo',
        'titulo',
        'mensaje',
        'data',
        'leida',
        'leida_at',
    ];

    protected $casts = [
        'data' => 'array',
        'leida' => 'boolean',
        'leida_at' => 'datetime',
    ];

    /**
     * Empresa a la que pertenece la notificación
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Scope para notificaciones no leídas
     */
    public function scopeNoLeidas($query)
    {
        return $query->where('leida', false);
    }

    /**
     * Scope para notificaciones recientes
     */
    public function scopeRecientes($query, $dias = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($dias));
    }

    /**
     * Marcar como leída
     */
    public function marcarComoLeida()
    {
        $this->update([
            'leida' => true,
            'leida_at' => now(),
        ]);
    }
}
