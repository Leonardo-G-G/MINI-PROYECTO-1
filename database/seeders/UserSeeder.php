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
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('nimda'),
            'role' => 'administrador',
            'tipo_cliente' => null,
        ]);

        // Crear usuario gerente
        User::create([
            'name' => 'gerente',
            'email' => 'gerente@gmail.com',
            'password' => Hash::make('etnereg'),
            'role' => 'gerente',
            'tipo_cliente' => null,
        ]);

        // Crear usuario cliente
        User::create([
            'name' => 'cliente',
            'email' => 'cliente@gmail.com',
            'password' => Hash::make('etneilc'),
            'role' => 'cliente',
            'tipo_cliente' => 'comprador',
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
