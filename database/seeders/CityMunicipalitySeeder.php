<?php

namespace Database\Seeders;

use App\Models\CityMunicipality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CityMunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();

        $cities = collect(Http::get('https://psgc.gitlab.io/api/cities-municipalities.json')->json());
        $now = now();
        $cities = $cities->map(function ($r) use ($now) {
            return [
                'region_code' => $r['regionCode'],
                'province_code' => $r['provinceCode'],
                'code' => $r['code'],
                'name' => $r['name'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        });
        $cities->chunk(300)->each(function ($chunk) {
            CityMunicipality::query()->insert($chunk->toArray());
        });

        DB::commit();
    }
}
