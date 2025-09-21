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
        Schema::create('system_configs', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('value');
            $table->timestamps();
        });
        $path = Storage::disk('s3')->putFileAs('configs', new \Illuminate\Http\File(public_path('images/gcash.jpg')), 'gcash.jpg');
        $url = Storage::disk('s3')->url($path);
        DB::table('system_configs')->insert([
            ['key' => 'gcash_qr', 'value' => $url],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_configs');
    }
};
