<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductoPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['administrador', 'gerente', 'cliente']);
    }

    public function view(User $user, Producto $producto): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->role === 'administrador';
    }

    public function update(User $user, Producto $producto): bool
    {
        return in_array($user->role, ['administrador', 'gerente']);
    }

    public function delete(User $user, Producto $producto): bool
    {
        return $user->role === 'administrador';
    }
}
