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
        Schema::create('partner_listing_paymnets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('no_of_listing');
            $table->string('no_year');
            $table->string('total_amount');
            $table->enum('payment_status',['success','pending'])->default('pending');
            $table->enum('payment_type',['0','1','2'])->comment('0=stripe,1=paypal,3=authorizenet')->nullable();
            $table->string('transaction_id')->nullable();
            $table->json('payment_response');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_listing_paymnets');
    }
};
