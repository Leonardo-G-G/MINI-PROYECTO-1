<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Seeder;



class UserSeeder extends Seeder
{
       public function run(): void
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Admin Principal',
            'email' => 'admin@ejemplo.com',
            'password' => Hash::make('admin1234'),
            'role' => 'administrador',
            'tipo_cliente' => null,
        ]);

        // Crear usuario gerente
        User::create([
            'name' => 'Gerente General',
            'email' => 'gerente@ejemplo.com',
            'password' => Hash::make('gerente1234'),
            'role' => 'gerente',
            'tipo_cliente' => null,
        ]);

        // Crear 70 compradores
        User::factory()->count(70)->create([
            'role' => 'cliente',
            'tipo_cliente' => 'comprador',
        ]);

        // Crear 30 vendedores
        User::factory()->count(30)->create([
            'role' => 'cliente',
            'tipo_cliente' => 'vendedor',
        ]);
    }
}
