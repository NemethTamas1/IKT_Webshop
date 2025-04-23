<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->string('unit', 10); // Ez lesz a gr, db, pcs, ilyenek.
            $table->string('flavour', 45)->nullable(); 
            $table->integer('stock')->default(0); 
            $table->integer('price')->default(666666); 
            $table->boolean('available')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
