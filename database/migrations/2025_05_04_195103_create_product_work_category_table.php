<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_work_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('work_category_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Prevent duplicate combinations
            $table->unique(['product_id', 'work_category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_work_category');
    }
};
