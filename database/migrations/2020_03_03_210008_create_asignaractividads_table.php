<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsignaractividadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignaractividads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_final')->nullable();
            $table->string('ebeduc', 5)->default('NO'); //SI, NO
            $table->double('peso'); //% dentro del % de la evaluacion academica
            $table->bigInteger('periodoacademico_id')->unsigned();
            $table->foreign('periodoacademico_id')->references('id')->on('periodoacademicos')->onDelete('cascade');
            $table->bigInteger('evaluacionacademica_id')->unsigned();
            $table->foreign('evaluacionacademica_id')->references('id')->on('evaluacionacademicas')->onDelete('cascade');
            $table->bigInteger('grupo_id')->unsigned();
            $table->foreign('grupo_id')->references('id')->on('grupos')->onDelete('cascade');
            $table->bigInteger('actividad_id')->unsigned();
            $table->foreign('actividad_id')->references('id')->on('actividads')->onDelete('cascade');
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
        Schema::dropIfExists('asignaractividads');
    }
}
