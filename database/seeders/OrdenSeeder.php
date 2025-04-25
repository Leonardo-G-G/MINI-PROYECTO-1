<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Orden;
use App\Models\User;
use Illuminate\Support\Carbon;

class OrdenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegúrate de tener usuarios antes de correr esto
        if (User::count() === 0) {
            User::factory(5)->create(); // Crea 5 usuarios si no existen
        }

        // Obtener los usuarios existentes
        $usuarios = User::all();

        // Crear una orden por cada usuario
        foreach ($usuarios as $usuario) {
            Orden::create([
                'user_id' => $usuario->id,
                'fecha' => Carbon::now()->subDays(rand(0, 30)), // Fecha aleatoria reciente
                'total' => rand(100, 1000), // Total aleatorio
            ]);
        }
    }
}
