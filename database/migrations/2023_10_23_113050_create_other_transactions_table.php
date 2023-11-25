<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_transactions', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('shipment_id')->unsigned()->nullable();
            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');

            $table->double('customs_price', 15 , 2)->nullable();
            $table->double('others_price', 15 , 2)->nullable();

            $table->string('desc')->nullable();

            $table->string('user_created')->nullable();



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
        Schema::dropIfExists('other_transactions');
    }
}
