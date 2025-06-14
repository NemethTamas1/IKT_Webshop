<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('role', 50)->default('user');
            $table->string('name', 100);
            $table->string('password');
            $table->string('email', 100)->unique(); 
            $table->string('phone')->nullable();
            $table->string('country', 60)->nullable();
            $table->string('city', 40)->nullable();
            $table->string('zip', 10)->nullable();
            $table->string('street_name', 60)->nullable();
            $table->string('street_type', 60)->nullable();
            $table->unsignedInteger('street_number')->nullable();
            $table->string('floor', 20)->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
