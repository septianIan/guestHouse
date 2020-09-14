<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMethodpaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('methodpayment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservationgroup_id')->constrained()->cascadeOnDelete();
            $table->string('methodPayment')->default(null);
            $table->string('value2')->default(null);
            $table->string('value3')->default(null);
            $table->string('value4')->default(null);
            $table->string('status')->default(0);
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
        Schema::dropIfExists('methodpayment');
    }
}
