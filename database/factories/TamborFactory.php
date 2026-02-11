<?php

namespace Database\Factories;

use App\Models\Tambor;
use Illuminate\Database\Eloquent\Factories\Factory;

class TamborFactory extends Factory
{
    protected $model = Tambor::class;

    public function definition(): array
    {
        return [
            'nombre' => fake()->word(),
            'descripcion' => fake()->sentence(),
        ];
    }
}

