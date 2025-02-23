<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Create verified suppliers
        $suppliers = Supplier::factory(5)->verified()->create();

        // Create a couple unverified suppliers
        Supplier::factory(2)->unverified()->create();

        // Create all categories first
        Category::factory(10)->create();

        // For each category, create 4 products (as defined in the factory)
        Category::all()->each(function ($category) use ($suppliers) {
            // Create active products (3 products per category)
            Product::factory(3)->create([
                'category_id' => $category->id,
                'supplier_id' => $suppliers->random()->id,
            ]);

            // Create 1 out of stock product per category
            Product::factory()->outOfStock()->create([
                'category_id' => $category->id,
                'supplier_id' => $suppliers->random()->id,
            ]);
        });

        // Create a few discontinued products randomly across categories
        Product::factory(5)->discontinued()->create([
            'supplier_id' => $suppliers->random()->id,
        ]);
    }
}
