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
        Schema::create('screen_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('screen_id')->index();
            $table->longText('screen_icon');
            $table->foreign('screen_id')->references('id')->on('screens')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screen_images');
    }
};
