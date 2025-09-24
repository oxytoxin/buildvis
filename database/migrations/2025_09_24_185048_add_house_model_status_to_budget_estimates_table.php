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
        Schema::table('budget_estimates', function (Blueprint $table) {
            $table->string('house_model_status')->default('none')->nullable()->after('house_model_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('budget_estimates', function (Blueprint $table) {
            $table->dropColumn('house_model_status');
        });
    }
};
