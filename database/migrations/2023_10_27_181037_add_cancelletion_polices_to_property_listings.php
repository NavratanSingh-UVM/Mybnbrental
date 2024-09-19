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
        Schema::table('property_listings', function (Blueprint $table) {
            $table->unsignedBigInteger('cancelletion_policies_id')->nullable()->after('upload_rental_polices');
            $table->foreign('cancelletion_policies_id')->references('id')->on('cancellention_policies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_listings', function (Blueprint $table) {
            $table->longText('cancel_rental_polices');
        });
    }
};
