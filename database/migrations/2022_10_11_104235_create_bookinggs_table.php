<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookinggsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookinggs', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_display_id');
            $table->unsignedBigInteger('user_id'); 
            $table->unsignedBigInteger('container_owner_id'); 
            $table->unsignedBigInteger('cargo_owner_id'); 
            $table->unsignedBigInteger('forwarder_id'); 
            $table->unsignedBigInteger('terminal_id'); 
            $table->unsignedBigInteger('booking_type_id'); 
            $table->unsignedBigInteger('train_start_id'); 
            $table->unsignedBigInteger('train_end_id'); 
            $table->unsignedBigInteger('carrier_in_id'); 
            $table->unsignedBigInteger('transport_type_id'); 
            $table->unsignedBigInteger('receiver_id'); 
            $table->unsignedBigInteger('pickup_id'); 
            $table->unsignedBigInteger('drop_of_id'); 
            $table->unsignedBigInteger('carrier_out_id'); 
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('transport_out_id');
            $table->string('booking_type')->nullable();
            $table->string('order_date')->nullable();
            $table->string('week_number')->nullable();
            $table->string('container_number')->nullable();
            $table->string('seal')->nullable();
            $table->string('adr')->nullable();
            $table->string('gate_in_date')->nullable();
            $table->string('reference_no')->nullable();
            $table->string('door_date')->nullable();
            $table->string('cc_address')->nullable();
            $table->string('door_delivery')->nullable();
            $table->string('truck_number')->nullable();
            $table->string('overtime')->nullable();
            $table->string('truck_leaving_date')->nullable();
            $table->string('truck_returning_date')->nullable();
            $table->string('comments')->nullable();
            $table->string('is_planned')->default(0);
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
        Schema::dropIfExists('bookinggs');
    }
}
