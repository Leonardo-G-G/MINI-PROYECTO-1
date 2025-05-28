<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductoController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Producto::class);

        $query = Producto::with(['categorias', 'vendedor']);

        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        if ($request->filled('categoria_id')) {
            $query->whereHas('categorias', function ($q) use ($request) {
                $q->where('categorias.id', $request->categoria_id);
            });
        }

        if (Auth::user()->role === 'cliente' && Auth::user()->tipo_cliente === 'vendedor') {
            $query->where('vendedor_id', Auth::id());
        }

        $productos = $query->get();
        $categorias = Categoria::all();

        if (Auth::user()->role === 'administrador') {
            return view('index_productos', compact('productos', 'categorias'));
        } elseif (Auth::user()->role === 'cliente' && Auth::user()->tipo_cliente === 'vendedor') {
            return view('cliente_vendedor', compact('productos', 'categorias'));
        } else {
            return view('cliente_comprador', compact('productos', 'categorias'));
        }
    }

    public function create()
    {
        $this->authorize('create', Producto::class);
        $categorias = Categoria::all();

        if (Auth::user()->role === 'administrador') {
            return view('admin_create_producto', compact('categorias'));
        }

        return view('create_producto', compact('categorias'));
    }

    public function store(StoreProductoRequest $request)
    {
        $this->authorize('create', Producto::class);

        $rutaImagen = null;
        if ($request->hasFile('foto')) {
            $rutaImagen = $request->file('foto')->store('productos', 'public');
        }

        $producto = Producto::create([
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
            'vendedor_id' => Auth::id(),
        ]);

        // Relación muchos a muchos con categorías
        if ($request->has('categoria_ids')) {
            $producto->categorias()->sync($request->categoria_ids);
        }

        return Auth::user()->role === 'administrador'
            ? redirect()->route('admin.productos.index')->with('success', 'Producto creado exitosamente.')
            : redirect()->route('cliente.vendedor.dashboard')->with('success', 'Producto creado exitosamente.');
    }

    public function edit(Producto $producto)
    {
        $this->authorize('update', $producto);
        $categorias = Categoria::all();

        if (Auth::user()->role === 'administrador') {
            return view('admin_edit_producto', compact('producto', 'categorias'));
        }

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
        ]);

        // Relación muchos a muchos con categorías
        if ($request->has('categoria_ids')) {
            $producto->categorias()->sync($request->categoria_ids);
        }

        return Auth::user()->role === 'administrador'
            ? redirect()->route('admin.productos.index')->with('success', 'Producto actualizado exitosamente.')
            : redirect()->route('cliente.vendedor.dashboard')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Producto $producto)
    {
        $this->authorize('delete', $producto);

        if ($producto->foto) {
            Storage::disk('public')->delete($producto->foto);
        }

        $producto->delete();

        return Auth::user()->role === 'administrador'
            ? redirect()->route('admin.productos.index')->with('success', 'Producto eliminado exitosamente.')
            : redirect()->route('cliente.vendedor.dashboard')->with('success', 'Producto eliminado exitosamente.');
    }
}