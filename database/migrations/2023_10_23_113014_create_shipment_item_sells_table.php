<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentItemSellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_item_sells', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('shipment_item_id')->unsigned()->nullable();
            $table->foreign('shipment_item_id')->references('id')->on('shipment_items')->onDelete('cascade');

            $table->string('client')->nullable();
            $table->string('bill_number')->nullable();

            $table->date('date')->nullable();

            $table->integer('quantity')->nullable();
            $table->integer('remaining_quantity')->nullable();


            $table->integer('damaged')->nullable();

            $table->double('price', 15 , 2)->nullable();

            $table->double('selling', 15 , 2)->nullable();

            $table->double('net_price', 15 , 2)->nullable();

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
        Schema::dropIfExists('shipment_item_sells');
    }
}
