<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShappingCarCreat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Shapping_car', function (Blueprint $table) {
            $table->increments('shop_id');
            $table->string('state');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('shop_id')->references('shop_id')->on('shop');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Shapping_car');
    }
}
