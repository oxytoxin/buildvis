<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('product_name')->nullable()->default(null);
            $table->string('name'); // e.g., "1/2 inch", "Red", "Steel"
            $table->string('product_slug')->storedAs('CONCAT(COALESCE(product_name, ""), "-", name)');
            $table->decimal('price', 12, 2);
            $table->string('sku')->nullable()->unique(); // Stock Keeping Unit
            $table->integer('stock_quantity')->default(0);
            $table->integer('minimum_stock_quantity')->default(10);
            $table->integer('minimum_order_quantity')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->boolean('counted_in_stats')->default(true);
            // Ensure unique combinations of product and name
            $table->unique(['product_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variations');
    }
};
