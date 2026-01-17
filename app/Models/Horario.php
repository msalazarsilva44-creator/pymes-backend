<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'dia_semana',
        'hora_apertura',
        'hora_cierre',
        'cerrado',
    ];

    protected $casts = [
        'hora_apertura' => 'datetime:H:i',
        'hora_cierre' => 'datetime:H:i',
        'cerrado' => 'boolean',
    ];

    /**
     * Empresa a la que pertenece
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}

