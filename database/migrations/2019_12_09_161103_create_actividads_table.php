<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 200);
            $table->string('descripcion')->nullable();
            $table->text('recurso')->default('NO'); //si la actividad es un documento, SI, NO
            $table->string('tipo', 50); // ACTIVIDAD-RECURSO, EXAMEN, ACTIVIDAD-VACIA, ACTIVIDAD-ESCRITA
            $table->String('ebeduc', 5)->default('NO'); //SI, NO
            $table->string('user_change', 100);
            $table->bigInteger('user_id')->unsigned(); // autor
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('evaluacionacademica_id')->unsigned();
            $table->foreign('evaluacionacademica_id')->references('id')->on('evaluacionacademicas')->onDelete('cascade');
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
        Schema::dropIfExists('actividads');
    }
}
