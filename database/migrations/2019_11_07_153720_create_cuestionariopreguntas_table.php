<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuestionariopreguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuestionariopreguntas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pregunta');
            $table->string('tipo', 50)->default('NORMAL'); //NORMAL, OTRA-PREGUNTA, RESPONDA
            $table->string('estado', 50)->default('ACTIVA'); //ACTIVA, ELIMINADA, INACTIVA
            $table->string('segunda_pregunta', 250)->nullable(); //SI TIPO = OTRA-PREGUNTA
            $table->string('user_change', 100);
            $table->bigInteger('cuestionarioentrevista_id')->unsigned();
            $table->foreign('cuestionarioentrevista_id')->references('id')->on('cuestionarioentrevistas')->onDelete('cascade');
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
        Schema::dropIfExists('cuestionariopreguntas');
    }
}
