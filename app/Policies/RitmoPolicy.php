<?php

namespace App\Policies;

use App\Models\Ritmo;
use App\Models\User;

class RitmoPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Todos pueden ver la lista
    }

    public function view(User $user, Ritmo $ritmo): bool
    {
        // Solo ritmos aprobados para alumnos, todos para profesores y admin
        if ($user->hasRole('alumno')) {
            return $ritmo->approved;
        }
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'profesor']);
    }

    public function update(User $user, Ritmo $ritmo): bool
    {
        // Admin puede editar todo, profesor solo sus propios ritmos
        if ($user->hasRole('admin')) {
            return true;
        }
        if ($user->hasRole('profesor')) {
            return $ritmo->created_by === $user->id;
        }
        return false;
    }

    public function delete(User $user, Ritmo $ritmo): bool
    {
        // Admin puede eliminar todo, profesor solo sus propios ritmos
        if ($user->hasRole('admin')) {
            return true;
        }
        if ($user->hasRole('profesor')) {
            return $ritmo->created_by === $user->id;
        }
        return false;
    }

    public function approve(User $user, Ritmo $ritmo): bool
    {
        return $user->hasRole('admin');
    }
}

