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
            $table->string("owner_first_name")->nullable()->after('upload_cancel_rental_polices');
            $table->string("owner_last_name")->nullable()->after('owner_first_name');
            $table->string("owner_phone")->nullable()->after('owner_last_name');
            $table->string("owner_address")->nullable()->after('owner_phone');
            $table->string("owner_email")->nullable()->after('owner_address');
            $table->string("owner_city")->nullable()->after('owner_email');
            $table->string("owner_type")->nullable()->after('owner_city');
            $table->string("owner_state")->nullable()->after('owner_type');
            $table->string("owner_zipcode")->nullable()->after('owner_state');
            $table->string("owner_owner_fax")->nullable()->after('owner_zipcode');
            $table->string("owner_profile_image")->nullable()->after('owner_owner_fax');
            $table->date('subscription_date')->after('owner_profile_image')->nullable();
            $table->enum('approval',['0','1'])->after('subscription_date')->default('0')->comment('0=Inactive,1=Active');
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
