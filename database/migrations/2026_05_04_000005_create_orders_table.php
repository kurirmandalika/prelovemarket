<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('buyer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_title');
            $table->string('product_image')->nullable();
            $table->decimal('total_price', 12, 2);
            $table->text('shipping_address');
            $table->string('expedition');
            $table->string('shipping_status')->default('pending')->index();
            $table->string('payment_status')->default('paid')->index();
            $table->string('status')->default('pending')->index();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['buyer_id', 'seller_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
