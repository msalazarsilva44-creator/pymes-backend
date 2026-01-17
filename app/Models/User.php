<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'apellido',
        'cedula',
        'email',
        'password',
        'role_id',
        'phone',
        'avatar',
        'direccion',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    /**
     * Relación con rol
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relación con empresa (si es empresa)
     */
    public function empresa()
    {
        return $this->hasOne(Empresa::class);
    }

    /**
     * Reseñas escritas por este usuario
     */
    public function resenas()
    {
        return $this->hasMany(Resena::class);
    }

    /**
     * Verificar si el usuario es admin
     */
    public function isAdmin()
    {
        if (!$this->role) {
            $this->load('role');
        }
        return $this->role && $this->role->name === 'admin';
    }

    /**
     * Verificar si el usuario es empresa
     */
    public function isEmpresa()
    {
        if (!$this->role) {
            $this->load('role');
        }
        return $this->role && $this->role->name === 'empresa';
    }

    /**
     * Verificar si el usuario es cliente
     */
    public function isCliente()
    {
        if (!$this->role) {
            $this->load('role');
        }
        return $this->role && $this->role->name === 'cliente';
    }
}

