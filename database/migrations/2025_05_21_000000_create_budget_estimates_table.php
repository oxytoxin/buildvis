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
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->json('structured_data'); // Stores the generated structured output
            $table->decimal('budget', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->integer('number_of_rooms');
            $table->integer('number_of_stories');
            $table->decimal('lot_length');
            $table->decimal('lot_width');
            $table->decimal('lot_area')->storedAs('lot_length * lot_width');
            $table->decimal('floor_length');
            $table->decimal('floor_width');
            $table->decimal('floor_area')->storedAs('floor_length * floor_width');
            $table->string('status')->default('processing'); // draft, submitted, approved, rejected
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes(); // For archiving estimates
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_estimates');
    }
};
