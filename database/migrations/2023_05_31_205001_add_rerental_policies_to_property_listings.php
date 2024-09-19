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
            $table->longText("rental_policies")->after('rates_notes')->nullable();
            $table->string("upload_rental_polices")->after("rental_policies")->nullable();
            $table->longText("cancel_rental_polices")->after("upload_rental_polices")->nullable();
            $table->string("upload_cancel_rental_polices")->after("cancel_rental_polices")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_listings', function (Blueprint $table) {
            //
        });
    }
};
