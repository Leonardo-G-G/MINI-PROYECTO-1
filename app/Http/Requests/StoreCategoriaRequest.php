<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Puedes agregar un control de acceso si es necesario
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
            'descripcion' => 'nullable|string|max:1000',
        ];
    }
}