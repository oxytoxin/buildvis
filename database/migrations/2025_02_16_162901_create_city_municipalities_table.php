<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('city_municipalities', function (Blueprint $table) {
            $table->id();
            $table->string('region_code')->constrained('region', 'code');
            $table->string('province_code')->constrained('provinces', 'code');
            $table->string('code')->unique()->index();
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('city_municipalities');
    }
};
