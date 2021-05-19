<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtunidadestandaraprendizajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctunidadestandaraprendizajes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('aprendizaje_id')->unsigned();
            $table->foreign('aprendizaje_id')->references('id')->on('aprendizajes')->onDelete('cascade');
            $table->bigInteger('ctunidadestandar_id')->unsigned();
            $table->foreign('ctunidadestandar_id')->references('id')->on('ctunidadestandars')->onDelete('cascade');
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
        Schema::dropIfExists('ctunidadestandaraprendizajes');
    }
}
