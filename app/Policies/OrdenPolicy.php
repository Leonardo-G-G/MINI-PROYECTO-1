<?php

namespace App\Policies;

use App\Models\Orden;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrdenPolicy
{
    // Solo administrador y gerente pueden ver órdenes
    public function viewAny(User $user): bool
    {
        return in_array($user->rol, ['administrador', 'gerente']);
    }

    public function view(User $user, Orden $orden): bool
    {
        return $this->viewAny($user);
    }

    // Administrador y cliente pueden crear
    public function create(User $user): bool
    {
        return in_array($user->rol, ['administrador', 'cliente']);
    }

    // Solo administrador y gerente pueden actualizar
    public function update(User $user, Orden $orden): bool
    {
        return in_array($user->rol, ['administrador', 'gerente']);
    }

    // Solo el administrador puede eliminar
    public function delete(User $user, Orden $orden): bool
    {
        return $user->rol === 'administrador';
    }

    public function restore(User $user, Orden $orden): bool
    {
        return false;
    }

    public function forceDelete(User $user, Orden $orden): bool
    {
        return false;
    }
}
