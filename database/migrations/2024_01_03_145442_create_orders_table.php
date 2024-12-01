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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            //transaction time
            $table->integer('totalQuantity');
            $table->integer('totalPrice');
            $table->integer('subTotal');
            $table->foreignId('memberId')->nullable()->constrained('members');
            $table->integer('memberDiscount')->nullable();
            $table->integer('totalPajak');
            $table->integer('serviceFee');
            $table->foreignId('voucherId')->nullable()->constrained('voucher_discounts');
            $table->integer('voucherDiscount')->nullable();
            $table->string('paymentMethod');
            $table->foreignId('idKasir')->nullable()->constrained('kasirs');
            $table->foreignId('userId')->nullable()->constrained('users');
            $table->string('namaKasir');

            $table->timestamp('transactionTime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
