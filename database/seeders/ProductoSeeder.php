<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\User;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = Categoria::all();
        $vendedores = User::where('tipo_cliente', 'vendedor')->get();

        foreach ($vendedores as $vendedor) {
            $productos = Producto::factory()->count(3)->create([
                'vendedor_id' => $vendedor->id,
            ]);

            foreach ($productos as $producto) {
                // Asignar 1 a 2 categorías aleatorias por producto
                $producto->categorias()->attach(
                    $categorias->random(rand(1, 2))->pluck('id')->toArray()
                );
            }
        }
    }
}