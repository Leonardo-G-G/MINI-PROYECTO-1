<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVentaRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Puedes ajustar según tus necesidades; true si cualquier usuario autenticado puede hacer la solicitud
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'producto_id' => 'required|exists:productos,id',
            'ticket' => 'required|image|max:2048', // 2MB max
        ];
    }

    public function messages(): array
    {
        return [
            'producto_id.required' => 'Selecciona un producto.',
            'producto_id.exists' => 'El producto seleccionado no existe.',
            'ticket.required' => 'Sube una imagen del ticket.',
            'ticket.image' => 'El archivo debe ser una imagen válida.',
            'ticket.max' => 'La imagen no debe superar los 2MB.',
        ];
    }
}
