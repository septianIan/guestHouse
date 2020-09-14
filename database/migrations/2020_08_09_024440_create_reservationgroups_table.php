<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationgroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservationgroups', function (Blueprint $table) {
            $table->id();
            $table->string('groupName');
            $table->string('arrivaleDate');
            $table->string('departureDate');
            $table->string('namePerson');
            $table->bigInteger('contactPerson');
            $table->string('addressPerson');
            $table->string('specialRequest');
            $table->bigInteger('costRequest')->default(0);
            $table->string('estimateArrivale');
            $table->string('dateReservation');
            $table->string('status')->default(0);
            $table->bigInteger('totalRoomPayment');
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
        Schema::dropIfExists('reservationgroups');
    }
}
