<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;

class ProductoController extends Controller
{
    // Mostrar todos los productos para empleados
    public function index()
    {
        $this->authorize('viewAny', Producto::class);

        $productos = Producto::all();
        return view('empleado', compact('productos'));
    }

    // Mostrar productos al cliente
    public function clienteIndex()
    {
        $this->authorize('viewAny', Producto::class);

        $productos = Producto::all();
        return view('cliente', compact('productos'));
    }

    // Formulario para crear un nuevo producto
    public function create()
    {
        $this->authorize('create', Producto::class);

        return view('create_producto');
    }

    // Guardar nuevo producto
    public function store(StoreProductoRequest $request)
    {
        $this->authorize('create', Producto::class);

        Producto::create($request->validated());

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    // Formulario para editar un producto
    public function edit(Producto $producto)
    {
        $this->authorize('update', $producto);

        return view('edit_producto', compact('producto'));
    }

    // Actualizar un producto
    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        $this->authorize('update', $producto);

        $producto->update($request->validated());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    // Eliminar un producto
    public function destroy(Producto $producto)
    {
        $this->authorize('delete', $producto);

        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
