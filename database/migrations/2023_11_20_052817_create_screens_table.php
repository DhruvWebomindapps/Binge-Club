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
        Schema::create('screens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('state_id')->index();
            $table->unsignedBigInteger('city_id')->index();
            $table->unsignedBigInteger('location_id')->index();
            $table->string('screen_name')->nullable();
            $table->string('admin_name')->nullable();
            $table->string('admin_phone')->nullable();
            $table->string('admin_email')->nullable();
            $table->boolean('status');
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->integer('max_people')->default(0);
            $table->integer('capacity')->default(0);
            $table->integer('priority')->default(0);
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screens');
    }
};
