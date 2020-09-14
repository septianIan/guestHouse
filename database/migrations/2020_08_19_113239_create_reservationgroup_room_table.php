<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationgroupRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservationgroup_room', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservationgroup_id');
            $table->unsignedBigInteger('room_id');

            $table->foreign('reservationgroup_id')->references('id')->on('reservationgroups')->onDelete('cascade');
            
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
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
        Schema::dropIfExists('reservationgroup_room');
    }
}
