<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

class OrdenController extends Controller
{
    // Mostrar todas las órdenes del cliente
    public function index()
    {
        $ordenes = Orden::where('user_id', Auth::id())->with('productos')->get();
        return view('mis_ordenes', compact('ordenes'));
    }

    // Mostrar formulario para crear nueva orden (ya lo haces en dashboard, así que no necesitamos create())

    // Guardar una nueva orden
    public function store(Request $request)
    {
        $productosSeleccionados = [];

        foreach ($request->productos as $producto) {
            if (isset($producto['id'])) {
                $productosSeleccionados[] = $producto;
            }
        }

        if (empty($productosSeleccionados)) {
            return back()->with('error', 'Debes seleccionar al menos un producto.');
        }

        // Crear la orden
        $orden = Orden::create([
            'user_id' => Auth::id(),
            'fecha' => now(),
            'total' => 0, // Temporal, se actualizará
        ]);

        $total = 0;
        foreach ($productosSeleccionados as $producto) {
            $productoModel = Producto::findOrFail($producto['id']);
            $orden->productos()->attach($productoModel->id, ['cantidad' => $producto['cantidad']]);
            $total += $productoModel->precio * $producto['cantidad'];
        }

        // Actualizar el total de la orden
        $orden->update(['total' => $total]);

        return redirect()->route('cliente.ordenes.index')->with('success', 'Orden creada exitosamente.');
    }

    // Mostrar una orden específica si quieres (opcional)
    public function show($id)
    {
        $orden = Orden::where('id', $id)->where('user_id', Auth::id())->with('productos')->firstOrFail();
        return view('show', compact('orden'));
    }
}
