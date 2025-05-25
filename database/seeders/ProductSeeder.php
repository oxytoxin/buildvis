<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $supplier = Supplier::create([
            'name' => 'Uncategorized Supplier',
        ]);

        $now = now();
        Category::insert([
            ['name' => 'Electrical', 'slug' => 'electrical', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Paintings', 'slug' => 'paintings', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Plumbing', 'slug' => 'plumbing', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Steel', 'slug' => 'steel', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Others', 'slug' => 'others', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
