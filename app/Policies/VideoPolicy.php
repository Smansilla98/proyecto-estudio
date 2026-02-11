<?php

namespace App\Policies;

use App\Models\Video;
use App\Models\User;

class VideoPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Video $video): bool
    {
        // Solo videos de ritmos aprobados para alumnos
        if ($user->hasRole('alumno')) {
            return $video->ritmo->approved;
        }
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'profesor']);
    }

    public function update(User $user, Video $video): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        if ($user->hasRole('profesor')) {
            return $video->ritmo->created_by === $user->id;
        }
        return false;
    }

    public function delete(User $user, Video $video): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        if ($user->hasRole('profesor')) {
            return $video->ritmo->created_by === $user->id;
        }
        return false;
    }
}

