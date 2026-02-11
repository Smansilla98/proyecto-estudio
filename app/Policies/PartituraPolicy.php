<?php

namespace App\Policies;

use App\Models\Partitura;
use App\Models\User;

class PartituraPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Partitura $partitura): bool
    {
        if ($user->hasRole('alumno')) {
            return $partitura->ritmo->approved;
        }
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'profesor']);
    }

    public function update(User $user, Partitura $partitura): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        if ($user->hasRole('profesor')) {
            return $partitura->ritmo->created_by === $user->id;
        }
        return false;
    }

    public function delete(User $user, Partitura $partitura): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        if ($user->hasRole('profesor')) {
            return $partitura->ritmo->created_by === $user->id;
        }
        return false;
    }
}

