<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('house_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('floor_length');
            $table->decimal('floor_width');
            $table->decimal('budget');
            $table->integer('number_of_stories');
            $table->integer('number_of_rooms');
            $table->text('description');
            $table->string('model_url');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('house_models');
    }
};
