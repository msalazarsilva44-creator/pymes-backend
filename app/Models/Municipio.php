<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'ciudad_id',
    ];

    /**
     * Relación con Ciudad (Estado)
     */
    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class);
    }

    /**
     * Relación con Empresas
     */
    public function empresas()
    {
        return $this->hasMany(Empresa::class);
    }
}
