<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYes24Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('yes24', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_danhmuc')->nullabel;;
            $table->string('tensanpham',250);
            $table->string('hinhanh',200);
            $table->string('giagoc',200)->nullabel;
            $table->string('giasale',200)->nullabel;
            $table->string('quatang',200)->nullabel;
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
        Schema::dropIfExists('yes24');
    }
}
