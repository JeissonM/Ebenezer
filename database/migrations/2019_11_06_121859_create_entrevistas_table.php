<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntrevistasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrevistas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->string('estado', 50)->default('PENDIENTE'); //PENDIENTE, APROBADA, REPROBADA, APLAZADA, RECHAZADA
            $table->text('anotaciones')->nullable();
            $table->string('user_change', 100);
            $table->bigInteger('agendacita_id')->unsigned();
            $table->foreign('agendacita_id')->references('id')->on('agendacitas')->onDelete('cascade');
            $table->bigInteger('cuestionarioentrevista_id')->unsigned()->nullable();
            $table->foreign('cuestionarioentrevista_id')->references('id')->on('cuestionarioentrevistas')->onDelete('cascade');
            $table->bigInteger('aspirante_id')->unsigned();
            $table->foreign('aspirante_id')->references('id')->on('aspirantes')->onDelete('cascade');
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
        Schema::dropIfExists('entrevistas');
    }
}
