<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear o obtener el rol admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Crear usuario admin si no existe
        $admin = User::firstOrCreate(
            ['email' => 'admin@escuela-tambores.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
            ]
        );

        // Asignar rol admin si no lo tiene
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        $this->command->info('Usuario admin creado exitosamente:');
        $this->command->info('Email: admin@escuela-tambores.com');
        $this->command->info('Password: admin123');
        $this->command->warn('⚠️ IMPORTANTE: Cambia la contraseña después del primer inicio de sesión');
    }
}

