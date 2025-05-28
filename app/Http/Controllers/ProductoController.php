<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductoController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Producto::class);

        if (Auth::user()->role === 'cliente' && Auth::user()->tipo_cliente === 'vendedor') {
            $productos = Auth::user()->productos;
        } else {
            $productos = Producto::with('categoria')->get(); // Incluye relación de categoría
        }

        return view('index_productos', compact('productos'));
    }

    public function create()
    {
        $this->authorize('create', Producto::class);
        $categorias = Categoria::all();
        return view('create_producto', compact('categorias'));
    }

    public function store(StoreProductoRequest $request)
    {
        $this->authorize('create', Producto::class);

        $rutaImagen = null;
        if ($request->hasFile('foto')) {
            $rutaImagen = $request->file('foto')->store('productos', 'public');
        }

        Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'autor' => $request->autor,
            'editorial' => $request->editorial,
            'numero_paginas' => $request->numero_paginas,
            'estado' => $request->estado,
            'precio' => $request->precio,
            'cantidad' => $request->cantidad,
            'foto' => $rutaImagen,
            'anio_publicacion' => $request->anio_publicacion,
            'categoria_id' => $request->categoria_id,
            'vendedor_id' => Auth::id(),
        ]);

        return redirect()->route('cliente.vendedor.dashboard')->with('success', 'Producto creado exitosamente.');
    }

    public function edit(Producto $producto)
    {
        $this->authorize('update', $producto);
        $categorias = Categoria::all();
        return view('edit_producto', compact('producto', 'categorias'));
    }

    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        $this->authorize('update', $producto);

        if ($request->hasFile('foto')) {
            if ($producto->foto) {
                Storage::disk('public')->delete($producto->foto);
            }
            $producto->foto = $request->file('foto')->store('productos', 'public');
        }

        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'autor' => $request->autor,
            'editorial' => $request->editorial,
            'numero_paginas' => $request->numero_paginas,
            'estado' => $request->estado,
            'precio' => $request->precio,
            'cantidad' => $request->cantidad,
            'anio_publicacion' => $request->anio_publicacion,
            'categoria_id' => $request->categoria_id,
        ]);

        return redirect()->back()->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Producto $producto)
    {
        $this->authorize('delete', $producto);

        if ($producto->foto) {
            Storage::disk('public')->delete($producto->foto);
        }

        $producto->delete();

        return redirect()->back()->with('success', 'Producto eliminado exitosamente.');
    }
}