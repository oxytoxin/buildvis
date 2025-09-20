<?php

namespace Database\Seeders;

use App\Models\WorkCategory;
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
            'requires_labor' => false,
            'labor_cost_rate' => 0.875,
        ]);

        $w = WorkCategory::create([
            'name' => 'Excavation and Site Preparation',
            'requires_labor' => false,
        ]);

        $w = WorkCategory::create([
            'name' => 'Concrete Works',
            'requires_labor' => true,
            'labor_cost_rate' => 0.5,
        ]);

        $w = WorkCategory::create([
            'name' => 'Walls and Partitions',
            'requires_labor' => true,
            'labor_cost_rate' => 0.45,
        ]);

        $w = WorkCategory::create([
            'name' => 'Formworks and Scaffolding',
            'requires_labor' => true,
            'labor_cost_rate' => 0.4,
        ]);

        $w = WorkCategory::create([
            'name' => 'Plastering',
            'requires_labor' => true,
            'labor_cost_rate' => 0.5,
        ]);

        $w = WorkCategory::create([
            'name' => 'Plumbing Materials',
            'requires_labor' => true,
            'labor_cost_rate' => 0.7,
        ]);

        $w = WorkCategory::create([
            'name' => 'Septic Tank',
            'requires_labor' => false,
            'labor_cost_rate' => 1,
        ]);

        $w = WorkCategory::create([
            'name' => 'Plumbing Fixtures',
            'requires_labor' => true,
            'labor_cost_rate' => 0.5,
        ]);

        $w = WorkCategory::create([
            'name' => 'Electrical Works',
            'requires_labor' => true,
            'labor_cost_rate' => 0.5,
        ]);

        $w = WorkCategory::create([
            'name' => 'Tile Works',
            'requires_labor' => true,
            'labor_cost_rate' => 0.5,
        ]);

        $w = WorkCategory::create([
            'name' => 'Doors and Windows',
            'requires_labor' => true,
            'labor_cost_rate' => 0.3,
        ]);

        $w = WorkCategory::create([
            'name' => 'Painting Works',
            'requires_labor' => true,
            'labor_cost_rate' => 0.8,
        ]);

        $w = WorkCategory::create([
            'name' => 'Ceiling Works',
            'requires_labor' => true,
            'labor_cost_rate' => 0.7,
        ]);

        $w = WorkCategory::create([
            'name' => 'Roof Framing and Tinsmithery',
            'requires_labor' => true,
            'labor_cost_rate' => 0.5,
        ]);

        $w = WorkCategory::create([
            'name' => 'General Requirements',
            'requires_labor' => true,
            'labor_cost_rate' => 1,
        ]);
    }
}
