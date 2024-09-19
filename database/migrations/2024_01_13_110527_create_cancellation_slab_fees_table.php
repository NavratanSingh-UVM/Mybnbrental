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
        Schema::create('cancellation_slab_fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cancelletion_polices_id');
            $table->foreign('cancelletion_polices_id')->references('id')->on('cancellention_policies');
            $table->string('days_period');
            $table->string('rates_in_percent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancellation_slab_fees');
    }
};
