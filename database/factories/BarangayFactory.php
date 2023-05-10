<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BarangayFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => fake()->city(),
        ];
    }
}
