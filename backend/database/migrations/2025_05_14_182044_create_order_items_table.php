<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_variant_id')->constrained('product_variants')->onDelete('cascade');
            $table->unsignedTinyInteger('ordered_quantity'); 
            $table->unsignedInteger('unit_price');
            $table->unsignedInteger('total_amount');
            $table->softDeletes();
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
