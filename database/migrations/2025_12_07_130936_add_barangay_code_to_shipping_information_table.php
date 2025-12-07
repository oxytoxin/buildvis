<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipping_information', function (Blueprint $table) {
            $table->string('barangay_code')->nullable()->after('city_municipality_code')->constrained('barangay', 'code');
        });
    }
};
