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
            $table->string('methodPayment')->nullable();
            $table->bigInteger('numberAccount')->default(0);
            $table->bigInteger('deposit')->default(0);
            $table->string('contactPerson');
            $table->string('address');
            $table->string('estimateArrivale')->nullable();
            $table->string('specialRequest')->nullable();
            /**
             * Status confirm = tamu sudah reservasi sudah membayar deposit
             * Status tentative = tamu reservasi tapi masih belum pasti check in    namun sudah deposit
             * Status = Changed tamu ganti jumlah kamar atau identitas
             * Status = CheckIn tamu reservasi sudah registrasi dan sudah check in
             */
            $table->string('status')->default('confirm');
            $table->timestamps();
            // $table->softDeletes();
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
