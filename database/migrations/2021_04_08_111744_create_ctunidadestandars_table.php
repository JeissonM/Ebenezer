<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtunidadestandarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctunidadestandars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('estandar_id')->unsigned();
            $table->foreign('estandar_id')->references('id')->on('estandars')->onDelete('cascade');
            $table->bigInteger('ctunidad_id')->unsigned();
            $table->foreign('ctunidad_id')->references('id')->on('ctunidads')->onDelete('cascade');
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
        Schema::dropIfExists('ctunidadestandars');
    }
}
