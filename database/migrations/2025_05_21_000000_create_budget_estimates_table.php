<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budget_estimates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->json('structured_data'); // Stores the generated structured output
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->string('status')->default('draft'); // draft, submitted, approved, rejected
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes(); // For archiving estimates
        });

        Schema::create('budget_estimate_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_estimate_id')->constrained()->onDelete('cascade');
            $table->foreignId('work_category_id')->nullable()->constrained()->onDelete('restrict');
            $table->foreignId('product_variation_id')->nullable()->constrained()->onDelete('restrict');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('quantity', 12, 2);
            $table->string('unit'); // e.g., pieces, kg, cubic meters, etc.
            $table->decimal('unit_price', 12, 2);
            $table->decimal('subtotal', 12, 2)->storedAs('quantity * unit_price');
            $table->string('type')->default('material'); // material, labor, equipment, etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_estimate_items');
        Schema::dropIfExists('budget_estimates');
    }
};
