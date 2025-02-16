<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();

        $provinces = collect(Http::get("https://psgc.gitlab.io/api/provinces.json")->json());
        $now = now();
        $provinces = $provinces->map(function ($r) use ($now) {
            return [
                'region_code' => $r['regionCode'],
                'code' => $r['code'],
                'name' => $r['name'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        });
        Province::query()->insert($provinces->toArray());
        DB::commit();
    }
}
