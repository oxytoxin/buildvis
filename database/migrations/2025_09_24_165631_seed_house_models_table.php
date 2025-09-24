<?php

use App\Models\HouseModel;
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
        Schema::table('house_models', function (Blueprint $table) {
            $table->decimal('budget', 16, 2)->change();
        });
        HouseModel::create([
            'name' => 'Compact Two-Story Minimalist House',
            'floor_length' => 8,
            'floor_width' => 6,
            'number_of_stories' => 2,
            'number_of_rooms' => 2,
            'budget' => 2500000,
            'model_url' => 'house-models/house-1.glb',
            'description' => 'A small minimalist two-story house designed for efficiency. Clean rectangular form, simple facade, and large windows for ventilation. Ideal for starter homes or small lots.',
        ]);

        HouseModel::create([
            'name' => 'Modern Two-Story House with Porch',
            'floor_length' => 10,
            'floor_width' => 8,
            'number_of_stories' => 2,
            'number_of_rooms' => 3,
            'budget' => 4000000,
            'model_url' => 'house-models/house-2.glb',
            'description' => 'A cozy modern two-story house with an entry porch and carport. Balanced use of glass and concrete accents provides openness and privacy.',
        ]);

        HouseModel::create([
            'name' => 'Contemporary Two-Story Family Home',
            'floor_length' => 12,
            'floor_width' => 9,
            'number_of_stories' => 2,
            'number_of_rooms' => 5,
            'budget' => 6500000,
            'model_url' => 'house-models/house-3.glb',
            'description' => 'A contemporary two-story house with clean lines, spacious living areas, and large windows. Includes an integrated staircase and a compact footprint for urban lots.',
        ]);

        HouseModel::create([
            'name' => 'Modern Two-Story House with Side Windows',
            'floor_length' => 15,
            'floor_width' => 11,
            'number_of_stories' => 2,
            'number_of_rooms' => 6,
            'budget' => 8500000,
            'model_url' => 'house-models/house-4.glb',
            'description' => 'A modern two-story house featuring wide vertical glass panels at the front and additional side windows. Includes a covered carport and bold facade with black-and-white contrast.',
        ]);

        HouseModel::create([
            'name' => 'Contemporary Two-Story House with Balcony',
            'floor_length' => 16,
            'floor_width' => 12,
            'number_of_stories' => 2,
            'number_of_rooms' => 7,
            'budget' => 10000000,
            'model_url' => 'house-models/house-5.glb',
            'description' => 'A contemporary family residence with cream walls, bold red accents, and a second-floor balcony. Designed with open interiors and large framed windows.',
        ]);

        HouseModel::create([
            'name' => 'Single-Story Modern Minimalist House',
            'floor_length' => 14,
            'floor_width' => 10,
            'number_of_stories' => 1,
            'number_of_rooms' => 4,
            'budget' => 5500000,
            'model_url' => 'house-models/house-6.glb',
            'description' => 'A wide single-story house with a spacious entry porch and patterned facade. Minimalist layout with strong rectangular elements and efficient interior planning.',
        ]);

        HouseModel::create([
            'name' => 'Modern Two-Story House with Balcony and Terrace',
            'floor_length' => 20,
            'floor_width' => 14,
            'number_of_stories' => 2,
            'number_of_rooms' => 9,
            'budget' => 12000000,
            'model_url' => 'house-models/house-7.glb',
            'description' => 'A premium two-story residence with balconies, a rooftop terrace, and vertical glass panels. Modern geometry combined with luxurious design for high-end living.',
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
