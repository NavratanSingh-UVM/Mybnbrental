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
        Schema::table('partner_listings', function (Blueprint $table) {
            $table->unsignedBigInteger('bussiness_category_id')->after('user_id');
            $table->foreign('bussiness_category_id')->references('id')->on('business_categories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partner_listings', function (Blueprint $table) {
            //
        });
    }
};
