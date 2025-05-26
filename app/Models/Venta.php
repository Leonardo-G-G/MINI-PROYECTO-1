<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'comprador_id',
        'ticket',
        'estado',
    ];

    public function comprador()
{
    return $this->belongsTo(User::class, 'comprador_id');
}

public function productos()
{
    return $this->belongsToMany(Producto::class, 'producto_venta')
                ->withPivot('cantidad', 'precio_unitario')
                ->withTimestamps();
}


    public function getTicketUrlAttribute()
    {
        return Storage::disk('private')->url($this->ticket);
    }
}
