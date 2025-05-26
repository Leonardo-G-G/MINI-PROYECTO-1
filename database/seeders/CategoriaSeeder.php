<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Ofertas',
                'descripcion' => 'Libros en descuento y promociones especiales.',
            ],
            [
                'nombre' => 'Ficción y Literatura',
                'descripcion' => 'Novelas, cuentos y obras de ficción.',
            ],
            [
                'nombre' => 'Ciencia y Tecnología',
                'descripcion' => 'Libros sobre avances científicos y tecnológicos.',
            ],
            [
                'nombre' => 'Infantiles y Juveniles',
                'descripcion' => 'Lecturas para niños y adolescentes.',
            ],
            [
                'nombre' => 'Desarrollo Personal',
                'descripcion' => 'Libros para mejorar habilidades y bienestar personal.',
            ],
        ];

        foreach ($categorias as $data) {
            Categoria::firstOrCreate(
                ['nombre' => $data['nombre']],
                ['descripcion' => $data['descripcion']]
            );
        }
    }
}