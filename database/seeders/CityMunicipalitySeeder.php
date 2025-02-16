<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CityMunicipality;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CityMunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();

        $provinces = collect(Http::get("https://psgc.gitlab.io/api/cities-municipalities.json")->json());
        $now = now();
        $provinces = $provinces->map(function ($r) use ($now) {
            return [
                'region_code' => $r['regionCode'],
                'province_code' => $r['provinceCode'],
                'code' => $r['code'],
                'name' => $r['name'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        });
        $provinces->chunk(300)->each(function ($provinces_chunk) {
            CityMunicipality::query()->insert($provinces_chunk->toArray());
        });

        DB::commit();
    }
}
