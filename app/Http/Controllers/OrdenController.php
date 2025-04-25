<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreOrdenRequest;
use App\Http\Requests\UpdateOrdenRequest;

class OrdenController extends Controller
{
    // Mostrar todas las órdenes
    public function index()
    {
        $this->authorize('viewAny', Orden::class);

        $ordenes = Orden::with('user', 'productos')->get();
        return view('ordenes.index', compact('ordenes'));
    }

    // Mostrar formulario para crear una nueva orden
    public function create()
    {
        $this->authorize('create', Orden::class);

        $productos = Producto::all();
        return view('ordenes.create', compact('productos'));
    }

    // Guardar una nueva orden
    public function store(StoreOrdenRequest $request)
    {
        $this->authorize('create', Orden::class);

        $orden = Orden::create([
            'user_id' => Auth::id(),
            'fecha' => now(),
            'total' => 0, // Se calculará después
        ]);

        $total = 0;
        foreach ($request->productos as $producto) {
            $orden->productos()->attach($producto['id'], ['cantidad' => $producto['cantidad']]);
            $productoModel = Producto::findOrFail($producto['id']);
            $total += $productoModel->precio * $producto['cantidad'];
        }

        $orden->update(['total' => $total]);

        return redirect()->route('ordenes.index')->with('success', 'Orden creada exitosamente.');
    }

    // Mostrar una orden específica
    public function show(Orden $orden)
    {
        $this->authorize('view', $orden);

        $orden->load('productos', 'user');
        return view('ordenes.show', compact('orden'));
    }

    // Mostrar formulario para editar una orden
    public function edit(Orden $orden)
    {
        $this->authorize('update', $orden);

        $productos = Producto::all();
        $orden->load('productos');
        return view('ordenes.edit', compact('orden', 'productos'));
    }

    // Actualizar una orden
    public function update(UpdateOrdenRequest $request, Orden $orden)
    {
        $this->authorize('update', $orden);

        $orden->productos()->detach();

        $total = 0;
        foreach ($request->productos as $producto) {
            $orden->productos()->attach($producto['id'], ['cantidad' => $producto['cantidad']]);
            $productoModel = Producto::findOrFail($producto['id']);
            $total += $productoModel->precio * $producto['cantidad'];
        }

        $orden->update([
            'total' => $total,
        ]);

        return redirect()->route('ordenes.index')->with('success', 'Orden actualizada exitosamente.');
    }

    // Eliminar una orden
    public function destroy(Orden $orden)
    {
        $this->authorize('delete', $orden);

        $orden->productos()->detach();
        $orden->delete();

        return redirect()->route('ordenes.index')->with('success', 'Orden eliminada exitosamente.');
    }
}
