<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ritmo;
use App\Models\Tambor;
use App\Models\Video;
use App\Models\User;

class RitmosSeeder extends Seeder
{
    public function run(): void
    {
        $profesor = User::where('email', 'profesor@escuela.com')->first();

        $tambores = Tambor::all()->keyBy('nombre');

        // Ritmo 1: Cumbia
        $ritmo1 = Ritmo::create([
            'nombre' => 'Cumbia',
            'descripcion' => 'Ritmo tradicional de cumbia colombiana',
            'bpm_default' => 120,
            'created_by' => $profesor->id,
            'approved' => true,
        ]);

        $ritmo1->tambores()->attach([
            $tambores['Timbal']->id,
            $tambores['Fondo Grave']->id,
            $tambores['Redoblante']->id,
        ]);

        // Ritmo 2: Samba
        $ritmo2 = Ritmo::create([
            'nombre' => 'Samba',
            'descripcion' => 'Ritmo brasileño de samba',
            'bpm_default' => 110,
            'created_by' => $profesor->id,
            'approved' => true,
        ]);

        $ritmo2->tambores()->attach([
            $tambores['Repique']->id,
            $tambores['Fondo Agudo']->id,
            $tambores['Medio']->id,
        ]);

        // Ritmo 3: Rock
        $ritmo3 = Ritmo::create([
            'nombre' => 'Rock Básico',
            'descripcion' => 'Ritmo básico de rock',
            'bpm_default' => 130,
            'created_by' => $profesor->id,
            'approved' => true,
        ]);

        $ritmo3->tambores()->attach([
            $tambores['Redoblante']->id,
            $tambores['Fondo Grave']->id,
            $tambores['Fondo Agudo']->id,
        ]);

        // Nota: Los videos se crearían con URLs reales en producción
        // Aquí solo creamos la estructura de ejemplo
    }
}

