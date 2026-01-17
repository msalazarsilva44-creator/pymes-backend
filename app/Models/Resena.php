<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resena extends Model
{
    use HasFactory;

    protected $table = 'resenas';

    protected $fillable = [
        'empresa_id',
        'user_id',
        'calificacion',
        'comentario',
        'respuesta_empresa',
        'respondido_at',
        'verificada',
        'visible',
    ];

    protected $casts = [
        'respondido_at' => 'datetime',
        'verificada' => 'boolean',
        'visible' => 'boolean',
    ];

    /**
     * Empresa que recibe la reseña
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Usuario que escribió la reseña
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope para reseñas visibles
     */
    public function scopeVisibles($query)
    {
        return $query->where('visible', true);
    }

    /**
     * Scope para reseñas verificadas
     */
    public function scopeVerificadas($query)
    {
        return $query->where('verificada', true);
    }
}

