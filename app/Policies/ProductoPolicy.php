<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\User;

class ProductoPolicy
{
    /**
     * Todos los roles pueden ver productos.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['administrador', 'gerente', 'cliente']);
    }

    public function view(User $user, Producto $producto): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Administradores pueden crear, y clientes tipo vendedor también.
     */
    public function create(User $user): bool
    {
        return $user->role === 'administrador'
            || ($user->role === 'cliente' && $user->tipo_cliente === 'vendedor');
    }

    /**
     * Administradores pueden editar cualquier producto.
     * Vendedores solo pueden editar los suyos.
     */
    public function update(User $user, Producto $producto): bool
    {
        return $user->role === 'administrador'
            || ($user->role === 'cliente'
                && $user->tipo_cliente === 'vendedor'
                && $producto->vendedor_id === $user->id);
    }

    /**
     * Administradores pueden eliminar cualquier producto.
     * Vendedores solo pueden eliminar los suyos.
     */
    public function delete(User $user, Producto $producto): bool
    {
        return $user->role === 'administrador'
            || ($user->role === 'cliente'
                && $user->tipo_cliente === 'vendedor'
                && $producto->vendedor_id === $user->id);
    }
}