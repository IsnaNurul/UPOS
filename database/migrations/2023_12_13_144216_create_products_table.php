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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable(); // description
            $table->integer('price')->default(0); // price
            $table->integer('discount')->default(0); // discount
            $table->integer('stock')->default(0); // stock
            $table->string('category'); // category
            $table->string('image')->nullable(); // image
            $table->foreignId('user_id')->constrained('users');
            $table->enum('unit', ['pcs', 'kg', 'g'])->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('last_stock_update')->nullable(); // last stock update
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
