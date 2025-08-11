<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserAccountsSeeder::class,
            RegionSeeder::class,
            ProvinceSeeder::class,
            CityMunicipalitySeeder::class,
            ProductSeeder::class,
            WorkSeeder::class,
            ProductVariationSeeder::class,
        ]);
    }
}
