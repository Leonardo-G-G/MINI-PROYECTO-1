<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion'];

    /**
     * Relación muchos a muchos con productos.
     */
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'categoria_producto')->withTimestamps();
    }
}