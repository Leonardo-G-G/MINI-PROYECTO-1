<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $this->route('categoria')->id, // Aquí accedemos correctamente al ID
            'descripcion' => 'nullable|string|max:1000',
        ];
    }
}
