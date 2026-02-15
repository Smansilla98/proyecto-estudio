<?php

namespace Database\Seeders;

use App\Models\Ritmo;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChilingaRitmosSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener usuario admin o crear uno por defecto
        $admin = User::where('email', 'admin@escuela-tambores.com')->first();
        if (!$admin) {
            $admin = User::first();
        }

        $ritmos = [
            // 1er Año
            ['nombre' => 'Ritmo Chilinga', 'anio' => 1, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Ritmo base de La Chilinga', 'bpm_default' => 120],
            ['nombre' => 'Ochosi', 'anio' => 1, 'autor' => 'D. Buira', 'tipo' => 'Adaptación', 'descripcion' => 'Ritmo Popular | Adaptación: D. Buira', 'bpm_default' => 120],
            ['nombre' => 'Marcha Camión', 'anio' => 1, 'autor' => 'D. Buira', 'tipo' => 'Adaptación', 'descripcion' => 'Ritmo Popular de Uruguay | Adaptación: D. Buira', 'bpm_default' => 120],
            ['nombre' => 'Ochosi en Murga', 'anio' => 1, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Variación de Ochosi en estilo murga', 'bpm_default' => 120],
            ['nombre' => 'Dance', 'anio' => 1, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Ritmo de danza', 'bpm_default' => 130],
            ['nombre' => 'Samba Reggae I', 'anio' => 1, 'autor' => 'D. Buira', 'tipo' => 'Adaptación', 'descripcion' => 'Ritmo Popular de Brasil | Adaptación: D. Buira', 'bpm_default' => 120],
            ['nombre' => 'Samba Reggae II', 'anio' => 1, 'autor' => 'D. Buira', 'tipo' => 'Adaptación', 'descripcion' => 'Ritmo Popular de Brasil | Adaptación: D. Buira', 'bpm_default' => 120],
            ['nombre' => 'Toque de Marcha', 'anio' => 1, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Ritmo de marcha', 'bpm_default' => 110],
            ['nombre' => 'Rap - Murga', 'anio' => 1, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Fusión de rap y murga', 'bpm_default' => 100],
            ['nombre' => 'Ixesa I', 'anio' => 1, 'autor' => 'D. Buira', 'tipo' => 'Adaptación', 'descripcion' => 'Ritmo Popular Brasil | Adaptación: D. Buira', 'bpm_default' => 120, 'opcional' => true, 'anio_opcional' => '1er o 2do año'],

            // 2do Año
            ['nombre' => 'Ixesa I', 'anio' => 2, 'autor' => 'D. Buira', 'tipo' => 'Adaptación', 'descripcion' => 'Ritmo Popular Brasil | Adaptación: D. Buira (Opcional 1er o 2do año)', 'bpm_default' => 120, 'opcional' => true, 'anio_opcional' => '1er o 2do año'],
            ['nombre' => 'Candombe Argentino', 'anio' => 2, 'autor' => 'Egle Martin, D. Buira', 'tipo' => 'Adaptación', 'descripcion' => 'Ritmo Argentino | Adaptación: Egle Martin, D. Buira', 'bpm_default' => 120],
            ['nombre' => 'Toque de Comparsa', 'anio' => 2, 'autor' => 'D. Buira', 'tipo' => 'Adaptación', 'descripcion' => 'Ritmo del litoral | Adaptación: D. Buira', 'bpm_default' => 120],
            ['nombre' => 'Sacateca', 'anio' => 2, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Ritmo original de La Chilinga', 'bpm_default' => 120],
            ['nombre' => 'Chiruda', 'anio' => 2, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Ritmo original de La Chilinga', 'bpm_default' => 120],
            ['nombre' => 'Ritmo de Chacarera', 'anio' => 2, 'autor' => 'D. Buira', 'tipo' => 'Adaptación', 'descripcion' => 'Ritmo Popular de Santiago del Estero | Adaptación: D. Buira', 'bpm_default' => 120],
            ['nombre' => 'Ritmo de Rumba', 'anio' => 2, 'autor' => 'D. Buira', 'tipo' => 'Adaptación', 'descripcion' => 'Ritmo Popular de Cuba | Adaptación: D. Buira', 'bpm_default' => 120],

            // 3er Año
            ['nombre' => 'Buscando a Coco', 'anio' => 3, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Ritmo original de La Chilinga', 'bpm_default' => 120],
            ['nombre' => 'Solo de timbales I', 'anio' => 3, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Solo para timbales', 'bpm_default' => 120],
            ['nombre' => 'Malamakua I', 'anio' => 3, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Ritmo original de La Chilinga', 'bpm_default' => 120],
            ['nombre' => 'Solo de redoblantes(Chiruda)', 'anio' => 3, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Solo de redoblantes basado en Chiruda', 'bpm_default' => 120],
            ['nombre' => 'Afrotango', 'anio' => 3, 'autor' => 'M. Pacios', 'tipo' => 'Autor', 'descripcion' => 'Fusión de afro y tango (Opcional 3er o 4to año)', 'bpm_default' => 120, 'opcional' => true, 'anio_opcional' => '3er o 4to año'],
            ['nombre' => 'Mongokuta I', 'anio' => 3, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Ritmo original de La Chilinga', 'bpm_default' => 120],
            ['nombre' => 'Chiruda Blues', 'anio' => 3, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Variación blues de Chiruda', 'bpm_default' => 100],
            ['nombre' => 'Arabe', 'anio' => 3, 'autor' => 'Turca Zahra', 'tipo' => 'Autor', 'descripcion' => 'Ritmo de influencia árabe', 'bpm_default' => 120],
            ['nombre' => 'Batería', 'anio' => 3, 'autor' => 'T. Barbeira', 'tipo' => 'Autor', 'descripcion' => 'Ritmo de batería', 'bpm_default' => 120],

            // 4to Año
            ['nombre' => 'Iyesa II', 'anio' => 4, 'autor' => 'D. Buira', 'tipo' => 'Adaptación', 'descripcion' => 'Ritmo Popular Cuba | Adaptación: D. Buira', 'bpm_default' => 120],
            ['nombre' => 'La Meta', 'anio' => 4, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Ritmo original de La Chilinga', 'bpm_default' => 120],
            ['nombre' => 'Solo de Repiques(La Meta)', 'anio' => 4, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Solo de repiques basado en La Meta', 'bpm_default' => 120],
            ['nombre' => 'Afrotango', 'anio' => 4, 'autor' => 'M. Pacios', 'tipo' => 'Autor', 'descripcion' => 'Fusión de afro y tango (Opcional 3er o 4to año)', 'bpm_default' => 120, 'opcional' => true, 'anio_opcional' => '3er o 4to año'],
            ['nombre' => 'Muñequitos I', 'anio' => 4, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Ritmo original de La Chilinga', 'bpm_default' => 120],
            ['nombre' => 'Oxosi II', 'anio' => 4, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Segunda versión de Oxosi', 'bpm_default' => 120],
            ['nombre' => 'Kukomalo', 'anio' => 4, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Ritmo original (Opcional 4to o 5to Año)', 'bpm_default' => 120, 'opcional' => true, 'anio_opcional' => '4to o 5to Año'],
            ['nombre' => 'Samborombón', 'anio' => 4, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Ritmo original de La Chilinga', 'bpm_default' => 120],
            ['nombre' => 'Ritmo de Makuta(Cuba)', 'anio' => 4, 'autor' => 'D. Buira', 'tipo' => 'Adaptación', 'descripcion' => 'Ritmo Popular de Cuba | Adaptación: D. Buira', 'bpm_default' => 120],

            // 5to Año
            ['nombre' => 'Kukomalo', 'anio' => 5, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Ritmo original (Opcional 4to o 5to Año)', 'bpm_default' => 120, 'opcional' => true, 'anio_opcional' => '4to o 5to Año'],
            ['nombre' => 'Chilinga II', 'anio' => 5, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Segunda versión del ritmo Chilinga (Opcional 5to o 6to Año)', 'bpm_default' => 120, 'opcional' => true, 'anio_opcional' => '5to o 6to Año'],
            ['nombre' => 'Solo de Timbales II', 'anio' => 5, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Segundo solo de timbales', 'bpm_default' => 120],
            ['nombre' => 'Juancito', 'anio' => 5, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Ritmo original de La Chilinga', 'bpm_default' => 120],
            ['nombre' => 'Malamakua II', 'anio' => 5, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Segunda versión de Malamakua', 'bpm_default' => 120],
            ['nombre' => 'Toque en 7 - Timbales', 'anio' => 5, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Solo de timbales en compás de 7', 'bpm_default' => 120],

            // 6to Año
            ['nombre' => 'Chilinga II', 'anio' => 6, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Segunda versión del ritmo Chilinga (Opcional 5to o 6to Año)', 'bpm_default' => 120, 'opcional' => true, 'anio_opcional' => '5to o 6to Año'],
            ['nombre' => 'Santito', 'anio' => 6, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Ritmo original de La Chilinga', 'bpm_default' => 120],
            ['nombre' => 'Ritmo sobre Paradiddle', 'anio' => 6, 'autor' => 'D. Buira', 'tipo' => 'Adaptación', 'descripcion' => 'Adaptación: D. Buira', 'bpm_default' => 120],
            ['nombre' => 'Ayinde', 'anio' => 6, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Ritmo original de La Chilinga', 'bpm_default' => 120],
            ['nombre' => 'Sacateca II', 'anio' => 6, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Segunda versión de Sacateca', 'bpm_default' => 120],
            ['nombre' => 'Solo de Timbales II', 'anio' => 6, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Segundo solo de timbales', 'bpm_default' => 120],
            ['nombre' => 'Muñequitos II y III', 'anio' => 6, 'autor' => 'D. Buira', 'tipo' => 'Autor', 'descripcion' => 'Segunda y tercera versión de Muñequitos', 'bpm_default' => 120],
        ];

        foreach ($ritmos as $ritmoData) {
            Ritmo::updateOrCreate(
                ['nombre' => $ritmoData['nombre'], 'anio' => $ritmoData['anio']],
                array_merge($ritmoData, [
                    'created_by' => $admin->id,
                    'approved' => true, // Aprobar todos los ritmos del programa oficial
                ])
            );
        }

        $this->command->info('Ritmos de La Chilinga creados exitosamente.');
    }
}

