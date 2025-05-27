<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'autor',
        'editorial',
        'numero_paginas',
        'estado',
        'precio',
        'cantidad',
        'foto',
        'anio_publicacion',
        'categoria_id',
        'vendedor_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'vendedor_id');
    }

    public function ventas()
{
    return $this->belongsToMany(Venta::class, 'producto_venta')
                ->withPivot('cantidad', 'precio_unitario')
                ->withTimestamps();
}

}