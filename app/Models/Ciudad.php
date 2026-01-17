<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    use HasFactory;

    protected $table = 'ciudades';

    protected $fillable = [
        'nombre',
        'estado',
        'pais',
        'codigo_postal',
        'activa',
    ];

    protected $casts = [
        'activa' => 'boolean',
    ];

    /**
     * Empresas en esta ciudad
     */
    public function empresas()
    {
        return $this->hasMany(Empresa::class);
    }

    /**
     * Municipios de este estado (ciudad)
     */
    public function municipios()
    {
        return $this->hasMany(Municipio::class);
    }
}

