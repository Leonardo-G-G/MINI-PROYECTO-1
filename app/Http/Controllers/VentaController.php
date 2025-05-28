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

    
    public function adminDashboard()
    {
        $users = User::all();
        return view('administrador', compact('users'));
    }

    public function gerenteDashboard()
    {
        $users = User::whereNotIn('role', ['administrador', 'gerente'])->get();
        return view('gerente', compact('users'));
    }

    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::all();
        return view('administrador', compact('users'));
    }

    public function create()
    {
        $this->authorize('create', User::class);
        return view('create');
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validated();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'tipo_cliente' => $validated['role'] === 'cliente' ? $validated['tipo_cliente'] : null,
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado con éxito.');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validated();

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
            'role' => $validated['role'],
            'tipo_cliente' => $validated['role'] === 'cliente' ? $validated['tipo_cliente'] : null,
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado con éxito.');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado con éxito.');
    }
}