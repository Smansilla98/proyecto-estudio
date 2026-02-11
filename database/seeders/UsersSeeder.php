<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Crear Admin
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@escuela.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        // Crear Profesor
        $profesor = User::create([
            'name' => 'Profesor Demo',
            'email' => 'profesor@escuela.com',
            'password' => Hash::make('password'),
        ]);
        $profesor->assignRole('profesor');

        // Crear Alumnos
        $alumno1 = User::create([
            'name' => 'Alumno 1',
            'email' => 'alumno1@escuela.com',
            'password' => Hash::make('password'),
        ]);
        $alumno1->assignRole('alumno');

        $alumno2 = User::create([
            'name' => 'Alumno 2',
            'email' => 'alumno2@escuela.com',
            'password' => Hash::make('password'),
        ]);
        $alumno2->assignRole('alumno');

        $alumno3 = User::create([
            'name' => 'Alumno 3',
            'email' => 'alumno3@escuela.com',
            'password' => Hash::make('password'),
        ]);
        $alumno3->assignRole('alumno');
    }
}

