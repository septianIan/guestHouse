<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndividualReservationRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individual_reservation_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained()->onDelete('cascade');
            $table->string('totalRoomReserved');
            $table->string('typeOfRoom');
            $table->string('totalPax')->nullable();
            $table->string('roomRate');
            $table->string('discount')->nullable();
            $table->integer('status')->default(1);
            /**
             * Status = 0 tamu sudah checkOut atau sudah selesai
             * Status = 1 tamu booking
             * Status = 2 tamu sudah checkIn
             */
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('individual_reservation_rooms');
    }
}
