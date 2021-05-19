<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsignarlogrogrupomateriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignarlogrogrupomaterias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('logro_id');
            $table->foreign('logro_id')->references('id')->on('logros')->onDelete('cascade');
            $table->unsignedBigInteger('grupo_id');
            $table->foreign('grupo_id')->references('id')->on('grupos')->onDelete('cascade');
            $table->unsignedBigInteger('grado_id');
            $table->foreign('grado_id')->references('id')->on('grados')->onDelete('cascade');
            $table->unsignedBigInteger('unidad_id');
            $table->foreign('unidad_id')->references('id')->on('unidads')->onDelete('cascade');
            $table->unsignedBigInteger('jornada_id');
            $table->foreign('jornada_id')->references('id')->on('jornadas')->onDelete('cascade');
            $table->unsignedBigInteger('periodoacademico_id');
            $table->foreign('periodoacademico_id')->references('id')->on('periodoacademicos')->onDelete('cascade');
            $table->unsignedBigInteger('materia_id');
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
        Schema::dropIfExists('asignarlogrogrupomaterias');
    }
}
