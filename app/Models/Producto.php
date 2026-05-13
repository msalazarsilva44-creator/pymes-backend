<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'nombre',
        'descripcion',
        'precio',
        'cantidad',
        'activo',
        'es_basico',
        'orden',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'cantidad' => 'integer',
        'activo' => 'boolean',
        'es_basico' => 'boolean',
        'orden' => 'integer',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Imágenes del producto (máx. 5 en lógica de negocio)
     */
    public function imagenes()
    {
        return $this->hasMany(ProductoImagen::class)->orderBy('orden', 'asc');
    }

    /**
     * Items de órdenes que incluyen este producto
     */
    public function ordenItems()
    {
        return $this->hasMany(OrdenItem::class);
    }
}
