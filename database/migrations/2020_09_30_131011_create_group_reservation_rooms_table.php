<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupReservationRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_reservation_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservationgroup_id')->constrained()->onDelete('cascade');
            $table->string('totalRoomReserved');
            $table->string('typeOfRoom');
            $table->string('roomRate')->default(0);
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('group_reservation_rooms');
    }
}
