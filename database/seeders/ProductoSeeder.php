<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\User;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = Categoria::all();

        // Obtener todos los usuarios que son vendedores
        $vendedores = User::where('tipo_cliente', 'vendedor')->get();

        foreach ($vendedores as $vendedor) {
            // Crear 3 productos por cada vendedor
            Producto::factory()->count(3)->create([
                'vendedor_id' => $vendedor->id,
                'categoria_id' => $categorias->random()->id,
            ]);
        }
    }
 }