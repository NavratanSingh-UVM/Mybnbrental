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
        Schema::table('booking_information', function (Blueprint $table) {
            $table->unsignedBigInteger('cancelletion_id')->after('next_payment_date')->nullable();
            $table->foreign('cancelletion_id')->references('id')->on('cancellention_policies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_information', function (Blueprint $table) {
            //
        });
    }
};
