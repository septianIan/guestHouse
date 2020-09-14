<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationgroupMealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservationgroup_meal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservationgroup_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('meal_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->time('atTime');
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
        Schema::dropIfExists('reservationgroup_meal');
    }
}
