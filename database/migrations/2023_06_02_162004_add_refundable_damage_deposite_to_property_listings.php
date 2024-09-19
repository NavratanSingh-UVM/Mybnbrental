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
            $table->float("admin_fees")->after('rates_notes')->nullable();
            $table->float("cleaning_fees")->after('admin_fees')->nullable();
            $table->float("refundable_damage_deposite")->after('cleaning_fees')->nullable();
            $table->float("danage_waiver")->after('refundable_damage_deposite')->nullable();
            $table->float("peet_fee")->after('danage_waiver')->nullable();
            $table->float("extra_person_fee")->after('peet_fee')->nullable();
            $table->string("after_guest")->after('extra_person_fee')->nullable();
            $table->float("poolheating_fee")->after('after_guest')->nullable();
            $table->string("pool_heating_fees_perday")->after('poolheating_fee')->nullable();
            $table->time("check_in")->after('pool_heating_fees_perday')->nullable();
            $table->time("check_out")->after('check_in')->nullable();
            $table->float("tax_rates")->after('check_out')->nullable();
            $table->string("change_over")->after('tax_rates')->nullable();
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
