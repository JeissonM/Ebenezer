<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuestionarioprespuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuestionarioprespuestas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('respuesta');
            $table->string('user_change', 100);
            $table->bigInteger('cuestionariopregunta_id')->unsigned();
            $table->foreign('cuestionariopregunta_id')->references('id')->on('cuestionariopreguntas')->onDelete('cascade');
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
        Schema::dropIfExists('cuestionarioprespuestas');
    }
}
