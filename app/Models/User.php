<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Database\Factories\UserFactory;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;
    
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasAnyRole(['admin', 'profesor']);
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function ritmos()
    {
        return $this->hasMany(Ritmo::class, 'created_by');
    }
}

