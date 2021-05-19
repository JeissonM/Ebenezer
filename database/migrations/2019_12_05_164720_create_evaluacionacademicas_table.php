<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluacionacademicasTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('evaluacionacademicas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 150);
            $table->integer('peso');
            $table->string('user_change', 100);
            $table->bigInteger('sistemaevaluacion_id')->unsigned();
            $table->foreign('sistemaevaluacion_id')->references('id')->on('sistemaevaluacions')->onDelete('cascade');
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
        Schema::dropIfExists('evaluacionacademicas');
    }
}
