<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoEmpresa extends Model
{
    use HasFactory;

    protected $table = 'fotos_empresas';

    protected $fillable = [
        'empresa_id',
        'url',
        'descripcion',
        'es_principal',
        'orden',
    ];

    protected $casts = [
        'es_principal' => 'boolean',
    ];

    /**
     * Empresa a la que pertenece
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}

