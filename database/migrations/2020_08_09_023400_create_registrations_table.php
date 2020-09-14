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
            $table->string('name');
            $table->string('national');
            $table->string('passport');
            $table->string('occupation');
            $table->string('dateBirth');
            $table->string('address');
            $table->string('company');
            $table->string('arrivaleDate');
            $table->string('dapatureDate');
            $table->string('purpose');
            $table->string('commingFrom');
            $table->string('termPayment');
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
        Schema::dropIfExists('registrations');
    }
}
