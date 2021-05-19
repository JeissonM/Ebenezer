<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadpreguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividadpreguntas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('actividad_id')->unsigned();
            $table->foreign('actividad_id')->references('id')->on('actividads')->onDelete('cascade');
            $table->bigInteger('pregunta_id')->unsigned();
            $table->foreign('pregunta_id')->references('id')->on('preguntas')->onDelete('cascade');
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
        Schema::dropIfExists('actividadpreguntas');
    }
}
