<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'price',
                'stock_quantity',
                'minimum_stock_quantity',
                'minimum_order_quantity'
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->after('supplier_id');
            $table->integer('stock_quantity')->after('unit');
            $table->integer('minimum_stock_quantity')->default(10)->after('stock_quantity');
            $table->integer('minimum_order_quantity')->default(1)->after('minimum_stock_quantity');
        });
    }
};
