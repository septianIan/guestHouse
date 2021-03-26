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
            $table->string('mediaReservation');
            $table->string('contactPerson');
            $table->string('addressPerson');
            $table->string('specialRequest')->nullable();
            $table->bigInteger('rateRequest')->nullable();
            $table->time('atTime')->nullable();
            $table->string('flightNumber')->nullable();
            $table->string('estimateArrivale');
            $table->string('dateReservation');
            $table->string('clerk')->nullable();
            $table->string('status')->default('confirm');
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
        Schema::dropIfExists('reservationgroups');
    }
}
