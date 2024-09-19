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
        Schema::create('property_listings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('property_name');
            $table->string('property_main_photos');
            $table->string('square_feet');
            $table->bigInteger('property_type_id')->unsigned();
            $table->foreign('property_type_id')->references('id')->on('property_types')->onDelete('cascade');
            $table->string('sleeps');
            $table->string('avg_night_rates');
            $table->string('baths');
            $table->longText('description');
            $table->bigInteger('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->bigInteger('state_id')->unsigned();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->bigInteger('region_id')->unsigned()->nullable();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->bigInteger('city_id')->unsigned()->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->bigInteger('sub_city_id')->unsigned()->nullable();
            $table->foreign('sub_city_id')->references('id')->on('sub_cities')->nullable();
            $table->text('address');
            $table->string('town');
            $table->string('zip_code');
            // $table->string('owner_name');
            // $table->string('owner_address');
            // $table->string('owner_phone');
            // $table->string('owner_alternate_phone');
            // $table->string('owner_fax');
            // $table->string('owner_email');
            // $table->string('owner_alternate_email');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_listings');
    }
};
