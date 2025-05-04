<?php

namespace Database\Seeders;

use App\Models\WorkCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $w = WorkCategory::create([
            'name' => 'Embankment',
            'has_materials' => false
        ]);

        $w->work_items()->create([
            'name' => 'Material Cost',
            'unit' => 'cubic meter',
            'unit_cost' => 400
        ]);
        $w->work_items()->create([
            'name' => 'Labor Cost',
            'unit' => 'cubic meter',
            'unit_cost' => 350
        ]);

        $w = WorkCategory::create([
            'name' => 'Excavation and Site Preparation',
            'has_materials' => false
        ]);

        $w->work_items()->create([
            'name' => 'Excavation',
            'unit' => 'cubic meter',
            'unit_cost' => 500
        ]);

        $w->work_items()->create([
            'name' => 'Back Fill',
            'unit' => 'cubic meter',
            'unit_cost' => 500
        ]);

        $w = WorkCategory::create([
            'name' => 'Concrete Works',
            'has_materials' => true,
            'labor_cost_rate' => 0.5
        ]);
    }
}
