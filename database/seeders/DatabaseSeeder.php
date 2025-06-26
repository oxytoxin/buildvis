<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Mark John Lerry',
            'middle_name' => 'Acosta',
            'last_name' => 'Casero',
            'email' => 'markjohnlerrycasero@gmail.com',
            'gender' => 'male',
            'phone_number' => '09123456789',
            'password' => 'password'
        ]);
        $this->call([
            RegionSeeder::class,
            ProvinceSeeder::class,
            CityMunicipalitySeeder::class,
            ProductSeeder::class,
            WorkSeeder::class,
            ProductVariationSeeder::class,
        ]);
    }
}
