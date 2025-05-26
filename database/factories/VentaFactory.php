<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Venta>
 */
class VentaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'producto_id' => Producto::factory(),
        'comprador_id' => User::factory(),
        'ticket' => 'tickets/fake-ticket.jpg', // Simulación
        'estado' => 'pendiente',
    ];
    }
}
