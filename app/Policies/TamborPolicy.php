<?php

namespace App\Policies;

use App\Models\Tambor;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TamborPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Todos pueden ver tambores
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tambor $tambor): bool
    {
        return true; // Todos pueden ver tambores
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Solo admin y profesor pueden crear tambores
        return $user->hasAnyRole(['admin', 'profesor']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tambor $tambor): bool
    {
        // Solo admin y profesor pueden editar tambores
        return $user->hasAnyRole(['admin', 'profesor']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tambor $tambor): bool
    {
        // Solo admin puede eliminar tambores
        return $user->hasRole('admin');
    }
}

