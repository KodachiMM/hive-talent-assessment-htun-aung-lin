<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->date('booking_date');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_name');
            $table->string('car_number', 10);
            $table->integer('duration');
            $table->text('note');
            $table->string('verification_number');
            $table->string('booking_status')->default('Confirmed');
            $table->double('total_amount');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
