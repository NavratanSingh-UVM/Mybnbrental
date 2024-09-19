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
        Schema::create('partner_listing_gallery_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_listing_id');
            $table->foreign('partner_listing_id')->references('id')->on('partner_listings')->onDelete('cascade')->onUpdate('cascade');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_listing_gallery_images');
    }
};
