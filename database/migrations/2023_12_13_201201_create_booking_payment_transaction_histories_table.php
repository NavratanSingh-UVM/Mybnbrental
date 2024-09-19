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
        Schema::create('booking_payment_transaction_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_information_id');
            $table->foreign('booking_information_id','bi_id')->references('id')->on('booking_information');
            $table->float('pay_amount',10,2);
            $table->string('transaction_id');
            $table->json('payment_response');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_payment_transaction_histories');
    }
};
