<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_items', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('shipment_id')->unsigned()->nullable();
            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');

            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            
            $table->integer('quantity')->nullable();
            $table->integer('remaining_quantity')->nullable();

            $table->double('invoice_price', 15 , 2)->nullable();
            $table->double('invoice_total', 15 , 2)->nullable();
            $table->double('invoice_price_sa', 15 , 2)->nullable();
            $table->double('invoice_total_sa', 15 , 2)->nullable();

            $table->double('total', 15 , 2)->nullable();

         

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
        Schema::dropIfExists('shipment_items');
    }
}
