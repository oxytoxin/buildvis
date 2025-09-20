<?php

use App\Enums\OrderStatuses;
use App\Enums\PaymentMethods;
use App\Enums\PaymentStatuses;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('customer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->tinyInteger('status')->default(OrderStatuses::CART); // cart, pending, processing, shipped, delivered, cancelled
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->text('shipping_address')->nullable();
            $table->tinyInteger('payment_status')->default(PaymentStatuses::PENDING); // pending, paid, failed
            $table->tinyInteger('payment_method')->default(PaymentMethods::CASH_ON_DELIVERY);
            $table->timestamp('placed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_variation_id')->constrained()->onDelete('restrict');
            $table->integer('quantity');
            $table->decimal('unit_price', 12, 2);
            $table->decimal('subtotal', 12, 2)->storedAs('quantity * unit_price');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
