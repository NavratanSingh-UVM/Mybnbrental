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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('package_id');
            $table->foreign('package_id')->references('id')->on('packages')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('no_of_property')->nullable();
            $table->integer('year')->nullable();
            $table->string('coupon')->nullable();
            $table->float("total_amount",10,2);
            $table->enum('type',[0,1,2])->comment('0=stripe,1=paypal,2=authorizenet');
            $table->string('transaction_id')->nullable();
            $table->string('payment_status')->nullable();
            $table->json('payment_response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
