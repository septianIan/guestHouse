<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderrDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderr_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('orderr_id');
            $table->foreign('orderr_id')->references('id')->on('orderrs');

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
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
        Schema::dropIfExists('orderr_details');
    }
}
