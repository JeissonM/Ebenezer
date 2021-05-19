<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preguntas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('pregunta');
            $table->integer('puntos');
            $table->string('tipo',100)->default('SELECCION MULTIPLE');//SELECCION MULTIPLE, RESPONDA
            $table->integer('respuesta_id')->nullable();
            $table->string('user_change', 100);
            $table->bigInteger('user_id')->unsigned(); // autor
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('grado_id')->unsigned();
            $table->foreign('grado_id')->references('id')->on('grados')->onDelete('cascade');
            $table->bigInteger('materia_id')->unsigned();
            $table->foreign('materia_id')->references('id')->on('materias')->onDelete('cascade');
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
        Schema::dropIfExists('preguntas');
    }
}
