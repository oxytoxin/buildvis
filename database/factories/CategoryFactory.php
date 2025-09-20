<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $categories = [
            'Cement and Concrete',
            'Steel and Metals',
            'Lumber and Wood Products',
            'Masonry and Bricks',
            'Roofing Materials',
            'Plumbing Supplies',
            'Electrical Materials',
            'Paint and Coatings',
            'Tiles and Flooring',
            'Hardware and Fasteners',
        ];

        $name = fake()->unique()->randomElement($categories);

        return [
            'name' => $name,
            'description' => fake()->paragraph(),
            'slug' => Str::slug($name),
        ];
    }
}
