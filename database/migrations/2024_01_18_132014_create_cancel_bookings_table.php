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
        Schema::create('cancel_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->foreign('booking_id')->references('id')->on('booking_information')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('cancellention_policies_id');
            $table->foreign('cancellention_policies_id')->references('id')->on('cancellention_policies')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('cancel_reason_id');
            $table->foreign('cancel_reason_id')->references('id')->on('cancellention_reasons')->onDelete('cascade')->onUpdate('cascade');
            $table->double('refundable_amount',10,2);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancel_bookings');
    }
};
