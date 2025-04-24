<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function productosComprados()
{
    return $this->hasManyThrough(
        Producto::class,
        Orden::class,
        'user_id', // Clave foránea en Orden que conecta con User
        'id', // Clave foránea en Producto que se relaciona en la tabla intermedia orden_producto
        'id', // Clave primaria local en User
        'orden_id' // Clave local en orden_producto
    );
}
public function ordenes()
{
    return $this->hasMany(Orden::class);
}


}
