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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('city_id')->nullable()->index();
            $table->unsignedBigInteger('location_id')->nullable()->index();
            $table->unsignedBigInteger('screen_id')->nullable()->index();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->float('price')->default(0);
            $table->float('grand_total')->default(0);
            $table->float('discount_percent')->nullable();
            $table->float('discount_price')->nullable();
            $table->date('discount_s_date')->nullable();
            $table->date('discount_e_date')->nullable();
            $table->boolean('status');
            $table->integer('priority')->default(0);
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('screen_id')->references('id')->on('screens')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
