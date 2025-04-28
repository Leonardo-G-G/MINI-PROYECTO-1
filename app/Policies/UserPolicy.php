<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['administrador', 'gerente']);
    }

    public function view(User $authUser, User $targetUser): bool
    {
        if ($authUser->role === 'administrador') return true;

        if ($authUser->role === 'gerente') {
            return !in_array($targetUser->role, ['gerente', 'administrador']);
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->role === 'administrador';
    }

    public function update(User $authUser, User $targetUser): bool
    {
        if ($authUser->role === 'administrador') return true;

        if ($authUser->role === 'gerente') {
            return !in_array($targetUser->role, ['gerente', 'administrador']);
        }

        return false;
    }

    public function delete(User $user, User $targetUser): bool
    {
        return $user->role === 'administrador';
    }
}
