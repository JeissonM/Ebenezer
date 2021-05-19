<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultadoactividadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultadoactividads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('calificacion')->default(0);
            $table->text('anotaciones_sistema')->nullable();
            $table->text('anotaciones_docente')->nullable();
            $table->string('recurso')->default('NO');
            $table->string('ebeduc', 5)->default('NO'); //SI, NO
            $table->double('peso'); //% dentro del % de la evaluacion academica
            $table->string('tipo', 50); // ACTIVIDAD-RECURSO, EXAMEN, ACTIVIDAD-VACIA, ACTIVIDAD-ESCRITA
            $table->bigInteger('periodoacademico_id')->unsigned();
            $table->foreign('periodoacademico_id')->references('id')->on('periodoacademicos')->onDelete('cascade');
            $table->bigInteger('evaluacionacademica_id')->unsigned();
            $table->foreign('evaluacionacademica_id')->references('id')->on('evaluacionacademicas')->onDelete('cascade');
            $table->bigInteger('grupo_id')->unsigned();
            $table->foreign('grupo_id')->references('id')->on('grupos')->onDelete('cascade');
            $table->bigInteger('asignaractividad_id')->unsigned();
            $table->foreign('asignaractividad_id')->references('id')->on('asignaractividads')->onDelete('cascade');
            $table->bigInteger('estudiante_id')->unsigned();
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');
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
        Schema::dropIfExists('resultadoactividads');
    }
}
