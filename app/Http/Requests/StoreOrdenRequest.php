<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrdenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Puedes personalizar esto si necesitas restricciones por rol
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'fecha' => 'required|date',
            'total' => 'required|numeric|min:0',
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ];
    }
}