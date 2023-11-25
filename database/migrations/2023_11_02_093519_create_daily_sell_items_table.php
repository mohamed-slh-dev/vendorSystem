<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailySellItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_sell_items', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('daily_sell_id')->unsigned()->nullable();
            $table->foreign('daily_sell_id')->references('id')->on('daily_sells')->onDelete('cascade');

            $table->bigInteger('shipment_id')->unsigned()->nullable();
            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');

            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');


            $table->integer('quantity')->nullable();

            $table->integer('damaged')->nullable();

            $table->double('price', 15 , 2)->nullable();


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
        Schema::dropIfExists('daily_sell_items');
    }
}
