<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();

        $regions = collect(Http::get('https://psgc.gitlab.io/api/regions.json')->json());
        $now = now();
        $regions = $regions->map(function ($r) use ($now) {
            return [
                'code' => $r['code'],
                'name' => $r['regionName'],
                'description' => $r['name'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        });
        Region::query()->insert($regions->toArray());
        DB::commit();
    }
}
