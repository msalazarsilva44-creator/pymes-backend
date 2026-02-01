<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $table = 'carrito';

    protected $fillable = [
        'user_id',
        'servicio_id',
        'empresa_id',
        'precio',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
    ];

    /**
     * Usuario dueño del carrito
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Servicio en el carrito
     */
    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    /**
     * Empresa del servicio
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
