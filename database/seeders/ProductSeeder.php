<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use App\Enums\ProductCategories;
use Spatie\SimpleExcel\SimpleExcelReader;

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
        $categories = Category::all()->mapWithKeys(fn($m) => [$m->name => $m->id])->toArray();
        $reader = SimpleExcelReader::create(storage_path('imports/materials.xlsx'));
        $rows = $reader->getRows();
        $rows->each(function ($row) use ($supplier, $categories) {
            $category = $categories[$row['Category']];
            Product::create([
                'name' => $row['Name'],
                'category_id' => $category,
                'supplier_id' => $supplier->id,
                'price' => $row['Price'],
                'unit' => $row['Unit'],
                'stock_quantity' => 10,
                'minimum_stock_quantity' => 10,
                'minimum_order_quantity' => 1,
                'status' => 'active',
            ]);
        });
        Product::create([
            'name' => 'Embankment Materials',
            'category_id' => ProductCategories::Others,
            'supplier_id' => $supplier->id,
            'price' => 400,
            'unit' => 'cu.m',
            'stock_quantity' => 999999,
            'minimum_stock_quantity' => 10,
            'minimum_order_quantity' => 1,
            'status' => 'active',
        ]);
        Product::create([
            'name' => 'Excavation',
            'category_id' => ProductCategories::Others,
            'supplier_id' => $supplier->id,
            'price' => 500,
            'unit' => 'cu.m',
            'stock_quantity' => 999999,
            'minimum_stock_quantity' => 10,
            'minimum_order_quantity' => 1,
            'status' => 'active',
        ]);
        Product::create([
            'name' => 'Back Fill',
            'category_id' => ProductCategories::Others,
            'supplier_id' => $supplier->id,
            'price' => 500,
            'unit' => 'cu.m',
            'stock_quantity' => 999999,
            'minimum_stock_quantity' => 10,
            'minimum_order_quantity' => 1,
            'status' => 'active',
        ]);
    }
}
