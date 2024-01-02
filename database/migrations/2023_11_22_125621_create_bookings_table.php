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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('city_id')->index()->nullable();
            $table->unsignedBigInteger('location_id')->index()->nullable();
            $table->unsignedBigInteger('screen_id')->index()->nullable();
            $table->unsignedBigInteger('time_slot_id')->index()->nullable();
            $table->unsignedBigInteger('package_id')->index()->nullable();
            $table->string('city_name')->nullable();
            $table->string('location_name')->nullable();
            $table->string('screen_name')->nullable();
            $table->integer('screen_capacity')->nullable();
            $table->string('time_slot_name')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('nick_name')->nullable();
            $table->string('partner_name')->nullable();
            $table->date('book_date')->nullable();
            $table->string('time_slot')->nullable();
            $table->string('package_title')->nullable();
            $table->string('package_amount')->nullable();
            $table->float('package_price')->nullable();
            $table->integer('package_dicount_percent')->nullable();
            $table->float('package_dicount_amount')->nullable();
            $table->date('package_discount_start_date')->nullable();
            $table->date('package_dicount_end_date')->nullable();
            $table->float('time_slot_amount')->nullable();
            $table->float('additional_amount')->default(0);
            $table->float('total_amount')->nullable();
            $table->float('gst_amount')->nullable();
            $table->float('grand_total_amount')->nullable();
            $table->string('with_decoration')->nullable();
            $table->integer('number_of_people')->nullable();
            $table->string('status')->nullable();
            $table->boolean('is_online_booking')->default(false);
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('booking_status')->default('booked');
            $table->string('payment_type')->default('paid');
            $table->double('advance')->default(0);
            $table->double('balance')->default(0);
            $table->text('notes')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('screen_id')->references('id')->on('screens')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('time_slot_id')->references('id')->on('timeslots')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
