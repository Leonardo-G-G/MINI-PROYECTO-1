<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orden extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'fecha', 'total'];

    public function productos()
    {
        return $this->belongsToMany(Producto::class)
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
