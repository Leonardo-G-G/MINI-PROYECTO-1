<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Categoria;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear algunas categorías con el factory
        $categoriaMedicamentos = Categoria::factory()->create(['nombre' => 'Medicamentos']);
        $categoriaSuplementos = Categoria::factory()->create(['nombre' => 'Suplementos']);
        $categoriaCuidadoPersonal = Categoria::factory()->create(['nombre' => 'Cuidado Personal']);

        // Insertar productos
        Producto::insert([
            [
                'nombre' => 'Paracetamol 500mg',
                'descripcion' => 'Tabletas para el alivio del dolor y la fiebre.',
                'precio' => 50.00,
                'cantidad' => 100,
                'categoria_id' => $categoriaMedicamentos->id, // Relación con categoría Medicamentos
            ],
            [
                'nombre' => 'Ibuprofeno 400mg',
                'descripcion' => 'Antiinflamatorio y analgésico en tabletas.',
                'precio' => 75.00,
                'cantidad' => 80,
                'categoria_id' => $categoriaMedicamentos->id, // Relación con categoría Medicamentos
            ],
            [
                'nombre' => 'Vitamina C 1000mg',
                'descripcion' => 'Suplemento vitamínico para fortalecer el sistema inmunológico.',
                'precio' => 120.00,
                'cantidad' => 60,
                'categoria_id' => $categoriaSuplementos->id, // Relación con categoría Suplementos
            ],
            [
                'nombre' => 'Gel antibacterial 500ml',
                'descripcion' => 'Gel desinfectante para manos.',
                'precio' => 90.00,
                'cantidad' => 150,
                'categoria_id' => $categoriaCuidadoPersonal->id, // Relación con categoría Cuidado Personal
            ],
            [
                'nombre' => 'Omeprazol 20mg',
                'descripcion' => 'Medicamento para tratar problemas de acidez estomacal.',
                'precio' => 65.00,
                'cantidad' => 70,
                'categoria_id' => $categoriaMedicamentos->id, // Relación con categoría Medicamentos
            ],
        ]);
    }
 }