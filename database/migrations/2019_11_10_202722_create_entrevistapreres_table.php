<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntrevistapreresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrevistapreres', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('respuesta')->nullable();
            $table->string('tipo', 50);
            $table->string('user_change', 100);
            $table->bigInteger('cuestionariopregunta_id')->unsigned();
            $table->foreign('cuestionariopregunta_id')->references('id')->on('cuestionariopreguntas')->onDelete('cascade');
            $table->bigInteger('cuestionarioprespuesta_id')->unsigned()->nullable();
            $table->foreign('cuestionarioprespuesta_id')->references('id')->on('cuestionarioprespuestas')->onDelete('cascade');
            $table->bigInteger('entrevista_id')->unsigned();
            $table->foreign('entrevista_id')->references('id')->on('entrevistas')->onDelete('cascade');
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
        Schema::dropIfExists('entrevistapreres');
    }
}
