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
        'vendedor_id',
        
    ];

    /**
     * Relación muchos a muchos con categorías.
     */
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categoria_producto')->withTimestamps();
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