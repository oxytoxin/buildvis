<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $materials = [
        'Cement and Concrete' => [
            ['name' => 'Portland Cement', 'unit' => 'bag', 'price_range' => [250, 350]],
            ['name' => 'Ready-Mix Concrete', 'unit' => 'cubic meter', 'price_range' => [3000, 4500]],
            ['name' => 'Concrete Blocks', 'unit' => 'piece', 'price_range' => [15, 30]],
            ['name' => 'Concrete Admixture', 'unit' => 'liter', 'price_range' => [150, 300]],
        ],
        'Steel and Metals' => [
            ['name' => 'Deformed Steel Bars', 'unit' => 'piece', 'price_range' => [200, 400]],
            ['name' => 'Galvanized Iron Sheets', 'unit' => 'piece', 'price_range' => [450, 800]],
            ['name' => 'Steel Wire', 'unit' => 'roll', 'price_range' => [1200, 2000]],
            ['name' => 'Steel Angle Bars', 'unit' => 'piece', 'price_range' => [300, 600]],
        ],
        'Lumber and Wood Products' => [
            ['name' => 'Plywood Sheets', 'unit' => 'piece', 'price_range' => [600, 1200]],
            ['name' => 'Lumber 2x4', 'unit' => 'piece', 'price_range' => [150, 300]],
            ['name' => 'Wood Planks', 'unit' => 'piece', 'price_range' => [200, 400]],
            ['name' => 'Marine Plywood', 'unit' => 'piece', 'price_range' => [800, 1500]],
        ],
        'Masonry and Bricks' => [
            ['name' => 'Red Clay Bricks', 'unit' => 'piece', 'price_range' => [8, 15]],
            ['name' => 'Concrete Hollow Blocks', 'unit' => 'piece', 'price_range' => [15, 25]],
            ['name' => 'Stone Veneer', 'unit' => 'square meter', 'price_range' => [500, 1000]],
            ['name' => 'Mortar Mix', 'unit' => 'bag', 'price_range' => [200, 350]],
        ],
        'Roofing Materials' => [
            ['name' => 'Metal Roofing Sheets', 'unit' => 'piece', 'price_range' => [400, 800]],
            ['name' => 'Roof Tiles', 'unit' => 'piece', 'price_range' => [40, 80]],
            ['name' => 'Roofing Nails', 'unit' => 'box', 'price_range' => [100, 200]],
            ['name' => 'Roof Sealant', 'unit' => 'gallon', 'price_range' => [500, 1000]],
        ],
        'Plumbing Supplies' => [
            ['name' => 'PVC Pipes', 'unit' => 'piece', 'price_range' => [150, 300]],
            ['name' => 'Copper Tubing', 'unit' => 'meter', 'price_range' => [200, 400]],
            ['name' => 'Pipe Fittings', 'unit' => 'piece', 'price_range' => [50, 100]],
            ['name' => 'Water Tank', 'unit' => 'piece', 'price_range' => [2000, 4000]],
        ],
        'Electrical Materials' => [
            ['name' => 'Electrical Wire', 'unit' => 'roll', 'price_range' => [1500, 3000]],
            ['name' => 'Circuit Breakers', 'unit' => 'piece', 'price_range' => [300, 600]],
            ['name' => 'Electrical Outlets', 'unit' => 'piece', 'price_range' => [50, 100]],
            ['name' => 'LED Lights', 'unit' => 'piece', 'price_range' => [100, 200]],
        ],
        'Paint and Coatings' => [
            ['name' => 'Interior Paint', 'unit' => 'gallon', 'price_range' => [800, 1500]],
            ['name' => 'Exterior Paint', 'unit' => 'gallon', 'price_range' => [1000, 2000]],
            ['name' => 'Primer', 'unit' => 'gallon', 'price_range' => [500, 1000]],
            ['name' => 'Wood Stain', 'unit' => 'gallon', 'price_range' => [600, 1200]],
        ],
        'Tiles and Flooring' => [
            ['name' => 'Ceramic Tiles', 'unit' => 'box', 'price_range' => [800, 1500]],
            ['name' => 'Porcelain Tiles', 'unit' => 'box', 'price_range' => [1000, 2000]],
            ['name' => 'Vinyl Flooring', 'unit' => 'roll', 'price_range' => [2000, 4000]],
            ['name' => 'Tile Grout', 'unit' => 'bag', 'price_range' => [200, 400]],
        ],
        'Hardware and Fasteners' => [
            ['name' => 'Screws', 'unit' => 'box', 'price_range' => [100, 200]],
            ['name' => 'Nails', 'unit' => 'box', 'price_range' => [80, 150]],
            ['name' => 'Bolts and Nuts', 'unit' => 'box', 'price_range' => [150, 300]],
            ['name' => 'Door Hinges', 'unit' => 'pair', 'price_range' => [100, 200]],
        ],
    ];

    public function definition(): array
    {
        $category = Category::inRandomOrder()->first() ?? Category::factory()->create();
        $material = fake()->randomElement($this->materials[$category->name]);

        return [
            'name' => $material['name'],
            'description' => fake()->paragraph(),
            'category_id' => $category->id,
            'price' => fake()->randomFloat(2, $material['price_range'][0], $material['price_range'][1]),
            'unit' => $material['unit'],
            'stock_quantity' => fake()->numberBetween(50, 1000),
            'minimum_order_quantity' => fake()->randomElement([1, 5, 10, 20, 50]),
            'status' => fake()->randomElement(['active', 'active', 'active', 'out_of_stock', 'discontinued']),
        ];
    }

    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'out_of_stock',
            'stock_quantity' => 0,
        ]);
    }

    public function discontinued(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'discontinued',
            'stock_quantity' => 0,
        ]);
    }
}
