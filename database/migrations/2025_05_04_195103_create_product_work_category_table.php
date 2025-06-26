<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variation_work_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variation_id')->constrained()->onDelete('cascade');
            $table->foreignId('work_category_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Prevent duplicate combinations
            $table->unique(['product_variation_id', 'work_category_id'], 'product_variation_work_category_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variation_work_category');
    }
};
