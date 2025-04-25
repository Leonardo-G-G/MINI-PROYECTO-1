<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Administrador
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'administrador',
        ]);

        // Gerente
        User::create([
            'name' => 'Gerente1',
            'email' => 'gerente@gmail.com',
            'password' => Hash::make('gerente123'),
            'role' => 'gerente',
        ]);

        // Cliente
        User::create([
            'name' => 'Cliente1',
            'email' => 'cliente@gmail.com',
            'password' => Hash::make('cliente123'),
            'role' => 'cliente',
        ]);

        
    }
}
