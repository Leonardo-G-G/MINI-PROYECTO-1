<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoriaController extends Controller
{
    use AuthorizesRequests;

    /**
     * Mostrar todas las categorías.
     */
    public function index()
    {
        $this->authorize('viewAny', Categoria::class);

        $categorias = Categoria::all();
        return view('index_categoria', compact('categorias'));
    }

    /**
     * Mostrar el formulario para crear una nueva categoría.
     */
    public function create()
    {
        $this->authorize('create', Categoria::class);

        return view('create_categoria');
    }

    /**
     * Almacenar una nueva categoría en la base de datos.
     */
    public function store(StoreCategoriaRequest $request)
    {
        $this->authorize('create', Categoria::class);

        Categoria::create($request->validated());

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Mostrar el formulario para editar una categoría.
     */
    public function edit(Categoria $categoria)
    {
        $this->authorize('update', $categoria);

        return view('edit_categoria', compact('categoria'));
    }

    /**
     * Actualizar una categoría existente en la base de datos.
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        $this->authorize('update', $categoria);

        // Actualizamos los datos de la categoría con los datos validados
        $categoria->update($request->validated());

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Eliminar una categoría de la base de datos.
     */
    public function destroy(Categoria $categoria)
    {
        $this->authorize('delete', $categoria);

        $categoria->delete();

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}
