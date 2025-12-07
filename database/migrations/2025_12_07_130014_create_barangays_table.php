<?php

use App\Models\Barangay;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barangays', function (Blueprint $table) {
            $table->id();
            $table->string('region_code')->constrained('region', 'code');
            $table->string('province_code')->constrained('provinces', 'code');
            $table->string('city_municipality_code')->constrained('city_municipalities', 'code');
            $table->string('code')->unique()->index();
            $table->string('name');
            $table->timestamps();
        });

        DB::beginTransaction();

        $barangays = collect(Http::get('https://psgc.gitlab.io/api/barangays.json')->json());
        $now = now();
        $barangays = $barangays->map(function ($r) use ($now) {
            return [
                'region_code' => $r['regionCode'],
                'province_code' => $r['provinceCode'],
                'city_municipality_code' => boolval($r['cityCode']) ? $r['cityCode'] : $r['municipalityCode'],
                'code' => $r['code'],
                'name' => $r['name'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        });
        $barangays->chunk(300)->each(function ($chunk) {
            Barangay::query()->insert($chunk->toArray());
        });

        DB::commit();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangays');
    }
};
