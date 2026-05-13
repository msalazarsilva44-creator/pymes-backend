<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioImagen extends Model
{
    use HasFactory;

    protected $table = 'servicio_imagenes';

    protected $fillable = [
        'servicio_id',
        'url',
        'orden',
    ];

    protected $casts = [
        'orden' => 'integer',
    ];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
