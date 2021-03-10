<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrycleaningDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drycleaning_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('drycleaning_id');
            $table->foreign('drycleaning_id')->references('id')->on('drycleanings')->cascadeOnUpdate();
            $table->unsignedBigInteger('package_id');
            $table->foreign('package_id')->references('id')->on('packages');
            $table->string('quantity',225);
            $table->string('unitprice',225);
            $table->string('amount',225);
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
        Schema::dropIfExists('drycleaning_details');
    }
}
