<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenItem extends Model
{
    use HasFactory;

    protected $table = 'orden_items';

    protected $fillable = [
        'orden_id',
        'servicio_id',
        'nombre_servicio',
        'descripcion_servicio',
        'precio',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
    ];

    /**
     * Orden a la que pertenece este item
     */
    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }

    /**
     * Servicio original (puede no existir si fue eliminado)
     */
    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
