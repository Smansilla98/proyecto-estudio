<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            AdminUserSeeder::class,
            TamboresSeeder::class,
            UsersSeeder::class,
            ChilingaRitmosSeeder::class, // Seeder con ritmos oficiales de La Chilinga
            RitmosSeeder::class, // Seeder de ejemplo (opcional)
        ]);
    }
}

