<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->route('user')->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:administrador,gerente,cliente',
            'tipo_cliente' => 'required_if:role,cliente|nullable|in:comprador,vendedor',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'Debes proporcionar un correo válido.',
            'email.unique' => 'Este correo ya está en uso.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'role.required' => 'Debes seleccionar un rol.',
            'role.in' => 'El rol seleccionado no es válido.',
            'tipo_cliente.required_if' => 'El tipo de cliente es obligatorio cuando el rol es cliente.',
            'tipo_cliente.in' => 'El tipo de cliente debe ser comprador o vendedor.',
        ];
    }
}
