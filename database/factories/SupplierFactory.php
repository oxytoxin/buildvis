<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    public function definition(): array
    {
        $companyTypes = ['Hardware', 'Construction Supply', 'Building Materials', 'Home Depot', 'Trading'];
        $companyNames = [
            'Metro', 'Pacific', 'Golden', 'Star', 'Royal', 'Premier', 'Elite',
            'Pioneer', 'United', 'National', 'Allied', 'Modern',
        ];

        return [
            'name' => fake()->randomElement($companyNames).' '.fake()->randomElement($companyTypes),
            'email' => fake()->unique()->companyEmail(),
            'contact_person' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'business_permit_number' => fake()->bothify('BP-####-????-####'),
            'is_verified' => fake()->boolean(80), // 80% chance of being verified
        ];
    }

    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_verified' => true,
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_verified' => false,
        ]);
    }
}
