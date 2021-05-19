<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResactividadrespsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resactividadresps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('puntos_obtenidos')->default(0);
            $table->string('estado', 50)->default('SIN CALIFICAR');
            $table->string('tipo', 100)->default('SELECCION MULTIPLE'); //SELECCION MULTIPLE, RESPONDA
            $table->text('respuesta')->nullable();
            $table->bigInteger('respuesta_id')->unsigned()->nullable();
            $table->foreign('respuesta_id')->references('id')->on('respuestas')->onDelete('cascade');
            $table->bigInteger('pregunta_id')->unsigned();
            $table->foreign('pregunta_id')->references('id')->on('preguntas')->onDelete('cascade');
            $table->bigInteger('resultadoactividad_id')->unsigned();
            $table->foreign('resultadoactividad_id')->references('id')->on('resultadoactividads')->onDelete('cascade');
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
        Schema::dropIfExists('resactividadresps');
    }
}
