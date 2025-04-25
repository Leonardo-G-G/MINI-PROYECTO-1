<?php

namespace App\Policies;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoriaPolicy
{
    // Todos pueden ver categorías
    public function viewAny(User $user): bool
    {
        return in_array($user->rol, ['administrador', 'gerente', 'cliente']);
    }

    public function view(User $user, Categoria $categoria): bool
    {
        return $this->viewAny($user);
    }

    // Solo el administrador puede crear
    public function create(User $user): bool
    {
        return $user->rol === 'administrador';
    }

    // Admin y gerente pueden editar
    public function update(User $user, Categoria $categoria): bool
    {
        return in_array($user->rol, ['administrador', 'gerente']);
    }

    // Solo el administrador puede eliminar
    public function delete(User $user, Categoria $categoria): bool
    {
        return $user->rol === 'administrador';
    }

    public function restore(User $user, Categoria $categoria): bool
    {
        return false;
    }

    public function forceDelete(User $user, Categoria $categoria): bool
    {
        return false;
    }
}