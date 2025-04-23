<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories'); 
            $table->foreignId('brand_id')->constrained('brands'); 
            $table->string('name', 100); 
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
            $table->string('product_line')->nullable(); 
            $table->boolean('avaliable')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
