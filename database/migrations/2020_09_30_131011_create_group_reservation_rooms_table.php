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
            $table->string('totalRoomReserved')->nullable();
            $table->string('typeOfRoom')->nullable();
            $table->string('roomRate')->nullable();
            $table->bigInteger('discount')->nullable();
            $table->integer('status')->default(1);
            /**
             * Status = 0 tamu sudah checkOut atau sudah selesai
             * Status = 1 tamu bookong
             * Status = 2 tamu sudah checkIn
             */
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
