<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'nombre',
        'descripcion',
        'precio',
        'precio_desde',
        'duracion',
        'activo',
        'orden',
    ];

    protected $casts = [
        'precio_desde' => 'decimal:2',
        'activo' => 'boolean',
        'orden' => 'integer',
    ];

    /**
     * Empresa que ofrece este servicio
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Imágenes del servicio (máximo 4)
     */
    public function imagenes()
    {
        return $this->hasMany(ServicioImagen::class)->orderBy('orden', 'asc');
    }
}

