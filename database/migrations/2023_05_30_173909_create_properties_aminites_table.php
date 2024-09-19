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
        Schema::create('properties_aminites', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('property_id')->unsigned();
            $table->bigInteger('aminities_id')->unsigned();
            $table->bigInteger('sub_aminities_id')->unsigned();
            $table->softDeletes();
            $table->foreign('property_id')->references('id')->on('property_listings')->onDelete('cascade');
            $table->foreign('aminities_id')->references('id')->on('main_aminities')->onDelete('cascade');
            $table->foreign('sub_aminities_id')->references('id')->on('sub_aminities')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties_aminites');
    }
};
