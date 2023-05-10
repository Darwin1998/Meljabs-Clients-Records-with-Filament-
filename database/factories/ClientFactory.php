<?php

namespace Database\Factories;

use App\Models\Barangay;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    public function definition()
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'amount' => fake()->numberBetween(1, 3000),
            'installation_date' => fake()->date(),
            'contact_number' => fake()->phoneNumber(),
            'status' => 'active',
            'barangay_id' => Barangay::query()->inRandomOrder()->limit(1)->first()->id,
        ];
    }
}
