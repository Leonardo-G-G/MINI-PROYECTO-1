<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria; // Asegúrate de incluir el modelo Categoria
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductoController extends Controller
{
    use AuthorizesRequests;

    // Mostrar todos los productos para empleados
    public function index()
    {
        $this->authorize('viewAny', Producto::class);

        $productos = Producto::all();
        return view('index_productos', compact('productos')); // Vista para listar productos
    }

    // Mostrar productos al cliente
    public function clienteIndex()
    {
        $this->authorize('viewAny', Producto::class);

        $productos = Producto::all();
        return view('cliente', compact('productos')); // Vista para el cliente
    }

    // Formulario para crear un nuevo producto
    public function create()
    {
        $this->authorize('create', Producto::class);

        // Obtener todas las categorías y pasarlas a la vista
        $categorias = Categoria::all(); 

        return view('create_producto', compact('categorias')); // Vista para crear un nuevo producto
    }

    // Guardar nuevo producto
    public function store(StoreProductoRequest $request)
    {
        $this->authorize('create', Producto::class);

        // Crear el producto con todos los campos validados
        Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'cantidad' => $request->cantidad,  // Aseguramos que se guarde la cantidad
            'categoria_id' => $request->categoria_id,
        ]);

        return redirect()->route('admin.productos.index')->with('success', 'Producto creado exitosamente.');
    }

    // Formulario para editar un producto
    public function edit(Producto $producto)
    {
        $this->authorize('update', $producto);

        // Obtener todas las categorías para el formulario de edición
        $categorias = Categoria::all();

        return view('edit_producto', compact('producto', 'categorias')); // Vista para editar el producto
    }

    // Actualizar un producto
    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        $this->authorize('update', $producto);

        // Actualizar el producto con los nuevos datos proporcionados
        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'cantidad' => $request->cantidad,  // Aseguramos que se actualice la cantidad
            'categoria_id' => $request->categoria_id,
        ]);

        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    // Eliminar un producto
    public function destroy(Producto $producto)
    {
        $this->authorize('delete', $producto);

        $producto->delete();

        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}

