<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailMasterBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_master_bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('masterBill_id');
            $table->foreign('masterBill_id')->references('id')->on('master_bills');
            $table->string('description');
            $table->date('date');
            $table->string('charge');
            $table->string('idTemporary');
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
        Schema::dropIfExists('detail_master_bills');
    }
}
