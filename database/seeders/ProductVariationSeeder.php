<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ProductVariationSeeder extends Seeder
{
    public function run(): void
    {
        $supplier = Supplier::first();
        $categories = Category::all()->mapWithKeys(fn($m) => [$m->name => $m->id])->toArray();

        // Define all products with their variations
        $products = [
            // Electrical Products
            [
                'name' => 'Orange Pipe',
                'category' => 'Electrical',
                'unit' => 'meter',
                'variations' => [
                    '1/2 inch' => 75,
                    '3/4 inch' => 90,
                    '1 inch' => 120,
                ]
            ],
            [
                'name' => 'Pannel Box',
                'category' => 'Electrical',
                'unit' => 'piece',
                'variations' => [
                    '4 holes' => 420,
                    '6 holes' => 520,
                    '8 holes' => 650,
                    '10 holes' => 1100,
                    '16 holes' => 1900,
                ]
            ],
            [
                'name' => 'Thhn',
                'category' => 'Electrical',
                'unit' => 'piece',
                'variations' => [
                    '6' => 15000,
                    '8' => 8250,
                    '10' => 5250,
                    '12' => 3750,
                    '14' => 2550,
                ]
            ],
            [
                'name' => 'Cicuit Breaker',
                'category' => 'Electrical',
                'unit' => 'piece',
                'variations' => [
                    '15Amps' => 380,
                    '20Amps' => 380,
                    '30Amps' => 380,
                    '40Amps' => 380,
                    '60Amps' => 380,
                    '100Amps' => 500,
                ]
            ],
            // Plumbing Products
            [
                'name' => 'Orange PVC Pie',
                'category' => 'Plumbing',
                'unit' => 'meter',
                'variations' => [
                    '2' => 250,
                    '3' => 520,
                    '4' => 580,
                ]
            ],
            [
                'name' => 'Blue Pipe',
                'category' => 'Plumbing',
                'unit' => 'meter',
                'variations' => [
                    '1/2 inch' => 90,
                    '3/4 inch' => 130,
                    '1 inch' => 150,
                ]
            ],
            [
                'name' => 'Elbow',
                'category' => 'Plumbing',
                'unit' => 'piece',
                'variations' => [
                    '2x45' => 30,
                    '2x90' => 35,
                    '3x45' => 70,
                    '3x90' => 75,
                    '4x45' => 80,
                    '4x90' => 85,
                ]
            ],
            [
                'name' => 'Tee',
                'category' => 'Plumbing',
                'unit' => 'piece',
                'variations' => [
                    '2x2' => 45,
                    '3x2' => 85,
                    '3x3' => 90,
                    '4x2' => 110,
                    '4x3' => 110,
                    '4x4' => 120,
                ]
            ],
            [
                'name' => 'Wye',
                'category' => 'Plumbing',
                'unit' => 'piece',
                'variations' => [
                    '2x2' => 45,
                    '3x2' => 80,
                    '3x3' => 85,
                    '4x2' => 110,
                    '4x3' => 120,
                    '4x4' => 130,
                ]
            ],
            // Steel Products
            [
                'name' => 'RSB',
                'category' => 'Steel',
                'unit' => 'piece',
                'variations' => [
                    '9 mm' => 90,
                    '10 mm' => 130,
                    '12 mm' => 175,
                    '16 mm' => 318,
                ]
            ],
            [
                'name' => 'Tubular',
                'category' => 'Steel',
                'unit' => 'piece',
                'variations' => [
                    '1x1x1.5' => 205,
                    '1x1x2.0' => 270,
                    '2x1x1.5' => 320,
                    '2x1x2.0' => 530,
                    '2x2x1.5' => 420,
                    '2x2x2.0' => 550,
                ]
            ],
            [
                'name' => 'C purlins',
                'category' => 'Steel',
                'unit' => 'piece',
                'variations' => [
                    '2x2x1.5' => 300,
                    '2x3x1.5' => 400,
                    '2x4x1.5' => 500,
                    '2x6x1.5' => 550,
                ]
            ],
            [
                'name' => 'A/Bar',
                'category' => 'Steel',
                'unit' => 'piece',
                'variations' => [
                    '1/4 x 1' => 440,
                    '1/4 x1 1/2' => 650,
                    '1/4 x 2' => 850,
                ]
            ],
            [
                'name' => 'Channel Bar',
                'category' => 'Steel',
                'unit' => 'piece',
                'variations' => [
                    '2x3' => 1200,
                    '2x4' => 1350,
                ]
            ],
            // Painting Products
            [
                'name' => 'Paint Brush',
                'category' => 'Paintings',
                'unit' => 'piece',
                'variations' => [
                    '1' => 25,
                    '2' => 45,
                    '3' => 65,
                    '4' => 85,
                ]
            ],
            [
                'name' => 'Roller Cotton',
                'category' => 'Paintings',
                'unit' => 'piece',
                'variations' => [
                    '4' => 65,
                    '7' => 90,
                ]
            ],
            [
                'name' => 'Acrytex',
                'category' => 'Paintings',
                'unit' => 'piece',
                'variations' => [
                    'Primer Pail' => 2350,
                    'Primer Galon' => 639,
                    'Red Galon' => 580,
                ]
            ],
            // Other Products
            [
                'name' => 'Tiles',
                'category' => 'Others',
                'unit' => 'piece',
                'variations' => [
                    '30x30' => 45,
                    '30x60' => 176,
                    '40x40' => 85,
                    '60x60' => 365,
                ]
            ],
            [
                'name' => 'Marine',
                'category' => 'Others',
                'unit' => 'piece',
                'variations' => [
                    '1/4' => 350,
                    '1/2' => 550,
                    '3/4' => 900,
                ]
            ],
            [
                'name' => 'Pinolic',
                'category' => 'Others',
                'unit' => 'piece',
                'variations' => [
                    '1/2' => 500,
                    '3/4' => 780,
                ]
            ],
            // Additional Products (previously hardcoded)
            [
                'name' => 'Embankment Materials',
                'category' => 'Others',
                'unit' => 'cubic meter',
                'variations' => [
                    'Standard' => 400,
                ]
            ],
            [
                'name' => 'Excavation',
                'category' => 'Others',
                'unit' => 'cubic meter',
                'variations' => [
                    'Standard' => 500,
                ]
            ],
            [
                'name' => 'Back Fill',
                'category' => 'Others',
                'unit' => 'cubic meter',
                'variations' => [
                    'Standard' => 500,
                ]
            ],
        ];

        foreach ($products as $productData) {
            // Create the product
            $product = Product::create([
                'name' => $productData['name'],
                'category_id' => $categories[$productData['category']],
                'supplier_id' => $supplier->id,
                'unit' => $productData['unit'],
                'status' => 'active',
            ]);

            // Create variations for the product
            foreach ($productData['variations'] as $name => $price) {
                ProductVariation::create([
                    'product_id' => $product->id,
                    'name' => $name,
                    'price' => $price,
                    'sku' => strtoupper(substr($product->name, 0, 3)) . '-' . str_replace(['/', ' ', 'x'], '', $name),
                    'stock_quantity' => 10,
                    'minimum_stock_quantity' => 10,
                    'minimum_order_quantity' => 1,
                    'is_active' => true,
                ]);
            }
        }
    }
}
