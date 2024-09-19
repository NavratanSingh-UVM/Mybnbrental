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
        Schema::create('sub_aminities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('main_aminities_id'); 
            $table->string('name');
            $table->enum('status',['0','1'])->default('1')->comment('0=inactive,1=active');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('main_aminities_id')->references('id')->on('main_aminities')->constrained()->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_aminities');
    }
};
