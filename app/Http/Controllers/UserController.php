<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    // Mostrar el dashboard según el rol del usuario
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->role === 'gerente') {
            $users = User::all();
            return view('gerente', compact('users'));
        }

        if ($user->role === 'administrador') {
            $users = User::all();
            return view('administrador', compact('users'));
        }

        if ($user->role === 'cliente') {
            return view('cliente');
        }

        return redirect()->route('login')->with('error', 'Rol no autorizado.');
    }

    // Mostrar todos los usuarios
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::all();
        return view('gerente', compact('users'));
    }

    // Mostrar formulario para crear un nuevo usuario
    public function create()
    {
        $this->authorize('create', User::class);

        return view('create');
    }

    // Guardar un nuevo usuario
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validated();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('gerente.usuarios.index')->with('success', 'Usuario creado con éxito.');
    }

    // Mostrar formulario para editar un usuario
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('edit', compact('user'));
    }

    // Actualizar un usuario
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validated();

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
            'role' => $validated['role'],
        ]);

        return redirect()->route('gerente.usuarios.index')->with('success', 'Usuario actualizado con éxito.');
    }

    // Eliminar un usuario
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();
        return redirect()->route('gerente.usuarios.index')->with('success', 'Usuario eliminado con éxito.');
    }
}
