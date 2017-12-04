<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MemberCreat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menber', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Identity_card_number')->nullable();
            $table->string('address')->nullable();
            $table->date('birthday')->nullable();
            $table->string('phont')->nullable();
            $table->string('sex',10)->nullable();
            $table->string('user_type')->default('customer');
            $table->timestamps();
            $table->foreign('id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menber');
    }
}
