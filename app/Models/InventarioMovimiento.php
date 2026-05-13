<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarioMovimiento extends Model
{
    use HasFactory;

    protected $table = 'inventario_movimientos';

    protected $fillable = [
        'proveedor_id',
        'producto_id',
        'tipo_movimiento',
        'cantidad',
        'cantidad_anterior',
        'cantidad_resultante',
        'comentario',
        'usuario_id',
        'fecha_movimiento',
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'cantidad_anterior' => 'integer',
        'cantidad_resultante' => 'integer',
        'fecha_movimiento' => 'datetime',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'proveedor_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
