<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('status')->default(\App\Enums\ProjectTaskStatuses::PENDING->value);
            $table->integer('parent_id')->default(-1);
            $table->integer('order')->default(0)->index();
            $table->integer('weight')->default(1);
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
