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
        Schema::create('booking_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('property_listings')->onUpdate('cascade')->onDelete('cascade');
            $table->date('check_in');
            $table->date('check_out');
            $table->float('total_amount',10,2);
            $table->enum('payment_type',['partial','full'])->nullable();
            $table->string('total_guest');
            $table->string('total_children')->default('0');
            $table->string('total_night');
            $table->json('booking_summary');
            $table->enum('status',['pending','confirmed','cancelled'])->nullable();
            $table->date('next_payment_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_information');
    }
};
