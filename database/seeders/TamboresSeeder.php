<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tambor;

class TamboresSeeder extends Seeder
{
    public function run(): void
    {
        $tambores = [
            ['nombre' => 'Timbal', 'descripcion' => 'Tambor de timbal'],
            ['nombre' => 'Fondo Grave', 'descripcion' => 'Tambor de fondo grave'],
            ['nombre' => 'Fondo Agudo', 'descripcion' => 'Tambor de fondo agudo'],
            ['nombre' => 'Redoblante', 'descripcion' => 'Tambor redoblante'],
            ['nombre' => 'Repique', 'descripcion' => 'Tambor repique'],
            ['nombre' => 'Medio', 'descripcion' => 'Tambor medio'],
        ];

        foreach ($tambores as $tambor) {
            Tambor::create($tambor);
        }
    }
}

