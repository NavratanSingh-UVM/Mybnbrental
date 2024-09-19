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
        Schema::table('property_bookings', function (Blueprint $table) {
            $table->enum('type',['0','1'])->comment('0=external,1=internal')->after('booking_time_stamps');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_bookings', function (Blueprint $table) {
            //
        });
    }
};
