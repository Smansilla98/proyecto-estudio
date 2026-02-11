<?php

namespace Database\Factories;

use App\Models\Ritmo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RitmoFactory extends Factory
{
    protected $model = Ritmo::class;

    public function definition(): array
    {
        return [
            'nombre' => fake()->words(2, true),
            'descripcion' => fake()->sentence(),
            'bpm_default' => fake()->numberBetween(60, 200),
            'created_by' => User::factory(),
            'approved' => false,
        ];
    }
}

