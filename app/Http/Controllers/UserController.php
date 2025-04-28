<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;

    // Mostrar el dashboard según el rol del usuario
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->role === 'gerente') {
            // Mostrar solo los usuarios que no sean Administradores ni Gerentes
            $users = User::whereNotIn('role', ['administrador', 'gerente'])->get();
            return view('gerente', compact('users')); // Vista para el gerente
        }

        if ($user->role === 'administrador') {
            $users = User::all();
            return view('administrador', compact('users')); // Vista para el administrador
        }

        if ($user->role === 'cliente') {
            return view('cliente'); // Vista para el cliente
        }

        return redirect()->route('login')->with('error', 'Rol no autorizado.');
    }

    // Mostrar todos los usuarios
    public function index()
    {
        $this->authorize('viewAny', User::class); // Se verifica si el usuario tiene permisos

        // Los administradores pueden ver todos los usuarios
        $users = User::all();
        return view('administrador', compact('users')); // Vista para administradores
    }

    // Mostrar formulario para crear un nuevo usuario
    public function create()
    {
        $this->authorize('create', User::class); // Verifica si el usuario tiene permisos para crear usuarios

        return view('create'); // Vista para crear un nuevo usuario
    }

    // Guardar un nuevo usuario
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class); // Verifica si el usuario tiene permisos para crear usuarios

        $validated = $request->validated();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado con éxito.');
    }

    // Mostrar formulario para editar un usuario
    public function edit(User $user)
    {
        // Solo administradores y gerentes pueden editar usuarios, pero los gerentes solo pueden editar usuarios que no sean administradores ni gerentes
        $this->authorize('update', $user);

        return view('edit', compact('user')); // Vista para editar un usuario
    }

    // Actualizar un usuario
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user); // Verifica si el usuario tiene permisos para actualizar el usuario

        $validated = $request->validated();

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado con éxito.');
    }

    // Eliminar un usuario
    public function destroy(User $user)
    {
        // Solo los administradores pueden eliminar usuarios
        $this->authorize('delete', $user);

        $user->delete();
        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado con éxito.');
    }
}

