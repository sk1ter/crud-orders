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
        Schema::create('order_has_product', function (Blueprint $table) {
           $table->foreignIdFor(\App\Models\Order::class, 'order_id')->references('id')->on('orders');
           $table->foreignIdFor(\App\Models\Product::class, 'product_id')->references('id')->on('products');
           $table->integer('quantity');

           $table->primary(['order_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_has_product');
    }
};
