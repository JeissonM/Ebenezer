<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstudiantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fecha_ingreso')->nullable();
            $table->string('estado', 50)->nullable()->default('NUEVO'); //para efectos de matricula cada año  MATRICULADO, NUEVO, REPROBADO, APROBADO, NIVELACION
            $table->string('barrio_residencia')->nullable();
            $table->string('pago', 50)->default('PENDIENTE')->nullable();
            $table->integer('grado_anterior')->nullable();
            $table->integer('periodo_anterior')->nullable();
            $table->bigInteger('periodoacademico_id')->unsigned(); //periodo académico actual
            $table->foreign('periodoacademico_id')->references('id')->on('periodoacademicos')->onDelete('cascade');
            $table->bigInteger('grado_id')->unsigned(); //grado actual
            $table->foreign('grado_id')->references('id')->on('grados')->onDelete('cascade');
            $table->bigInteger('unidad_id')->unsigned(); //unidad academica actual
            $table->foreign('unidad_id')->references('id')->on('unidads')->onDelete('cascade');
            $table->integer('estrato_id')->unsigned();
            $table->foreign('estrato_id')->references('id')->on('estratos')->onDelete('cascade');
            $table->bigInteger('jornada_id')->unsigned();
            $table->foreign('jornada_id')->references('id')->on('jornadas')->onDelete('cascade');
            $table->bigInteger('personanatural_id')->unsigned();
            $table->foreign('personanatural_id')->references('id')->on('personanaturals')->onDelete('cascade');
            $table->bigInteger('situacionestudiante_id')->unsigned();
            $table->foreign('situacionestudiante_id')->references('id')->on('situacionestudiantes')->onDelete('cascade');
            $table->bigInteger('categoria_id')->unsigned();
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
            $table->string('user_change', 100);
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
        Schema::dropIfExists('estudiantes');
    }
}
