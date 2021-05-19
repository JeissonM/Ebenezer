<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradomateriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gradomaterias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_change', 100);
            $table->bigInteger('periodoacademico_id')->unsigned();
            $table->foreign('periodoacademico_id')->references('id')->on('periodoacademicos')->onDelete('cascade');
            $table->bigInteger('grado_id')->unsigned();
            $table->foreign('grado_id')->references('id')->on('grados')->onDelete('cascade');
            $table->bigInteger('unidad_id')->unsigned();
            $table->foreign('unidad_id')->references('id')->on('unidads')->onDelete('cascade');
            $table->bigInteger('jornada_id')->unsigned();
            $table->foreign('jornada_id')->references('id')->on('jornadas')->onDelete('cascade');
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
        Schema::dropIfExists('gradomaterias');
    }
}
