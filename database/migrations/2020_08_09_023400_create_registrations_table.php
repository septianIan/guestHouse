<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('nationality');
            $table->string('passport');
            $table->string('occupation')->nullable();
            $table->string('dateBirth')->nullable();
            $table->string('homeAddress', 191);
            $table->string('company')->nullable();
            $table->string('purpose');
            $table->string('arrivaleDate');
            $table->string('departureDate');
            $table->string('comingFrom');
            $table->string('nextDestination');
            $table->string('termOfPayment');
            $table->string('numberAccount');
            $table->string('clerk')->nullable();
            // $table->string('expDate')->default(0);
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
        Schema::dropIfExists('registrations');
    }
}
