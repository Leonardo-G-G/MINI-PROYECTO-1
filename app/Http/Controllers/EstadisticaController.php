<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Support\Collection;

class EstadisticaController extends Controller
{
    public function index()
    {
        // Total de usuarios
        $totalUsuarios = User::count();

        $totalVendedores = User::where('role', 'cliente')->where('tipo_cliente', 'vendedor')->count();
        $totalCompradores = User::where('role', 'cliente')->where('tipo_cliente', 'comprador')->count();


        // Productos por categoría
        $productosPorCategoria = Categoria::withCount('productos')->get();

        // Producto más vendido
        $productoMasVendido = Producto::withCount(['ventas as total_vendidos' => function ($q) {
            $q->select(\DB::raw('SUM(cantidad)'));
        }])->orderByDesc('total_vendidos')->first();

        // Comprador más frecuente por categoría
        $compradorPorCategoria = Categoria::with(['productos.ventas.comprador'])
            ->get()
            ->map(function ($categoria) {
                $compradores = [];

                foreach ($categoria->productos as $producto) {
                    foreach ($producto->ventas as $venta) {
                        $id = $venta->comprador->id;
                        $compradores[$id] = ($compradores[$id] ?? 0) + 1;
                    }
                }

                arsort($compradores);
                $compradorId = key($compradores);

                return [
                    'categoria' => $categoria->nombre,
                    'comprador' => $compradorId ? User::find($compradorId)?->name : 'Sin datos',
                ];
            });

        return view('estadisticas', compact(
            'totalUsuarios',
            'totalVendedores',
            'totalCompradores',
            'productosPorCategoria',
            'productoMasVendido',
            'compradorPorCategoria'
        ));
    }
}