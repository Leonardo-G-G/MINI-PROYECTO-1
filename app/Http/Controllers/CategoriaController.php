<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Mostrar todas las categorías.
     */
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Mostrar el formulario para crear una nueva categoría.
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Almacenar una nueva categoría en la base de datos.
     */
    public function store(StoreCategoriaRequest $request)
    {
        // Crear la categoría con las validaciones del request
        Categoria::create($request->validated());

        // Redirigir con un mensaje de éxito
        return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Mostrar el formulario para editar una categoría.
     */
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Actualizar una categoría existente en la base de datos.
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        // Actualizar la categoría con las validaciones del request
        $categoria->update($request->validated());

        // Redirigir con un mensaje de éxito
        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Eliminar una categoría de la base de datos.
     */
    public function destroy(Categoria $categoria)
    {
        // Eliminar la categoría
        $categoria->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}
