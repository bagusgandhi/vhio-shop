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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('gross_amount');
            $table->string('va_number')->nullable();
            $table->string('bank')->nullable();
            $table->string('acquirer')->nullable();
            $table->string('transaction_time');
            $table->string('payment_type');
            $table->string('transaction_status');
            $table->string('transaction_id');
            $table->string('invoice');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->dateTime('expiry_time');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');   
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');        

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
