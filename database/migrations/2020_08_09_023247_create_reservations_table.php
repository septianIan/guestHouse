<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('guestName');
            $table->string('arrivaleDate');
            $table->string('departureDate');
            $table->string('mediaReservation');
            $table->string('methodPayment');
            $table->string('deposit');
            $table->string('contactPerson');
            $table->string('namePerson');
            $table->string('address');
            $table->string('estimateArrivale');
            $table->string('specialRequest');
            $table->string('total');
            $table->integer('status')->default('0');
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
        Schema::dropIfExists('reservations');
    }
}
