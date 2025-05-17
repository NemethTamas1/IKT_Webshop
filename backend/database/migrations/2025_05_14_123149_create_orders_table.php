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
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('shipping_email');
            $table->string('shipping_name');

            $table->string('shipping_phone');
            $table->string('shipping_country', 60);
            $table->string('shipping_city', 40);
            $table->string('shipping_zip', 10);
            $table->string('shipping_street_name', 60);
            $table->string('shipping_street_type', 60);
            $table->unsignedInteger('shipping_street_number');
            $table->string('shipping_floor', 20)->nullable();

            $table->string('orderstatus', 50)->default('pending');
            $table->unsignedInteger('totalamount');
            $table->unsignedInteger('totalquantity');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
