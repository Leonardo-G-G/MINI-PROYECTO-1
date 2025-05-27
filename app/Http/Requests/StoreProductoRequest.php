<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta solicitud.
     */
    public function authorize(): bool
    {
        
        return true;
    }

    /**
     * Reglas de validación que se aplican a la solicitud.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'autor' => 'required|string|max:255',
            'editorial' => 'nullable|string|max:255',
            'numero_paginas' => 'nullable|integer|min:1',
            'estado' => 'required|in:Nuevo,Seminuevo,Usado',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:0',
            'anio_publicacion' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'foto' => 'nullable|image|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
        ];
    }
}