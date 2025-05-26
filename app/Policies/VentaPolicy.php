<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Venta;

class VentaPolicy
{
    /**
     * Ver cualquier venta - solo gerentes.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'gerente';
    }

    /**
     * Ver una venta específica:
     * - El comprador (user_id)
     * - El vendedor del producto (producto->vendedor_id)
     * - Gerente o Administrador
     */
    public function view(User $user, Venta $venta): bool
    {
        return $user->id === $venta->user_id
            || $user->id === $venta->producto->vendedor_id
            || in_array($user->role, ['gerente', 'administrador']);
    }

    /**
     * Crear una venta - cualquier cliente.
     */
    public function create(User $user): bool
    {
        return $user->role === 'cliente';
    }

    /**
     * Solo el gerente puede validar ventas.
     */
    public function validar(User $user, Venta $venta): bool
    {
        return $user->role === 'gerente';
    }

    /**
     * Actualizar una venta (si se necesita) - ejemplo: gerente.
     */
    public function update(User $user, Venta $venta): bool
    {
        return $user->role === 'gerente';
    }

    /**
     * Eliminar una venta - solo gerente o comprador.
     */
    public function delete(User $user, Venta $venta): bool
    {
        return $user->id === $venta->user_id || $user->role === 'gerente';
    }

    public function restore(User $user, Venta $venta): bool
    {
        return false;
    }

    public function forceDelete(User $user, Venta $venta): bool
    {
        return false;
    }
}
