<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailySellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_sells', function (Blueprint $table) {
            $table->id();

            $table->date('date')->nullable();
            
            $table->string('client')->nullable();
            
            $table->string('bill_number')->nullable();

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
        Schema::dropIfExists('daily_sells');
    }
}
