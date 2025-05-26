<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar todos los seeders necesarios
        $this->call([
            UserSeeder::class,
            
            ProductoSeeder::class,
            CategoriaSeeder::class,
        ]);
    }
}
