<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    // Muestra el formulario de registro
    public function create()
    {
        return view('auth.register');
    }

    // Procesa el registro de un nuevo usuario
    public function store(Request $request)
    {
        // Validación de datos, incluyendo tipo_cliente
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'tipo_cliente' => ['required', 'in:comprador,vendedor'],
        ], [
            'password.confirmed' => 'Las contraseñas no coinciden, inténtalo nuevamente',
            'tipo_cliente.required' => 'El tipo de cliente es obligatorio',
            'tipo_cliente.in' => 'El tipo de cliente seleccionado no es válido',
        ]);

        // Crear usuario con tipo_cliente y rol cliente
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'cliente',
            'tipo_cliente' => $request->tipo_cliente,
        ]);

        // Disparar evento de registro
        event(new Registered($user));

        // Redirigir con mensaje de éxito
        return redirect()->route('register')->with('success', 'Registro exitoso. ¡Bienvenido!');
    }
}