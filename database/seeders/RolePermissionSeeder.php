<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos
        $permissions = [
            'ritmos.create',
            'ritmos.edit',
            'ritmos.delete',
            'ritmos.view',
            'ritmos.approve',
            'videos.create',
            'videos.edit',
            'videos.delete',
            'partituras.create',
            'partituras.edit',
            'partituras.delete',
            'users.manage',
            'users.assign-roles',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear roles
        $admin = Role::create(['name' => 'admin']);
        $profesor = Role::create(['name' => 'profesor']);
        $alumno = Role::create(['name' => 'alumno']);

        // Asignar permisos a Admin
        $admin->givePermissionTo(Permission::all());

        // Asignar permisos a Profesor
        $profesor->givePermissionTo([
            'ritmos.create',
            'ritmos.edit',
            'ritmos.delete',
            'ritmos.view',
            'videos.create',
            'videos.edit',
            'videos.delete',
            'partituras.create',
            'partituras.edit',
            'partituras.delete',
        ]);

        // Asignar permisos a Alumno
        $alumno->givePermissionTo([
            'ritmos.view',
        ]);
    }
}

