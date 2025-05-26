<?php

namespace Database\Factories;

use App\Models\Producto;
use App\Models\User;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word,
            'descripcion' => $this->faker->sentence,
            'autor' => $this->faker->name,
            'editorial' => $this->faker->company,
            'numero_paginas' => $this->faker->numberBetween(100, 500),
            'estado' => $this->faker->randomElement(['nuevo', 'usado']),
            'precio' => $this->faker->randomFloat(2, 50, 500),
            'cantidad' => $this->faker->numberBetween(1, 10),
            'anio_publicacion' => $this->faker->year,
            'foto' => 'libros/' . $this->faker->image('public/storage/libros', 200, 300, null, false),
            // Estos serán definidos en el seeder:
            'categoria_id' => Categoria::inRandomOrder()->first()->id ?? 1,
            'vendedor_id' => User::factory(),
        ];
    }
}
