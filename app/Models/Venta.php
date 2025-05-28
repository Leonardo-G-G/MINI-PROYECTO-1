<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'comprador_id',
        'ticket',
        'estado',
        'total', // este campo sí está en tu migración
    ];

    /**
     * Relación: una venta pertenece a un comprador (usuario).
     */
    public function comprador()
    {
        return $this->belongsTo(User::class, 'comprador_id');
    }

    /**
     * Relación: una venta tiene muchos productos mediante la tabla pivote.
     */
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_venta')
                    ->withPivot('cantidad', 'precio_unitario')
                    ->withTimestamps();
    }

    /**
     * Accesor para obtener la URL del ticket (comprobante) almacenado en disco privado.
     */
    public function getTicketUrlAttribute()
    {
        return Storage::disk('private')->url($this->ticket);
    }
}