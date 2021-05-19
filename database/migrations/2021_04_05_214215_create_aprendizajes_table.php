<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAprendizajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aprendizajes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('logro');
            $table->text('logro_negativo');
            $table->bigInteger('componentecompetencia_id')->unsigned();
            $table->foreign('componentecompetencia_id')->references('id')->on('componentecompetencias')->onDelete('cascade');
            $table->bigInteger('estandarcomponente_id')->unsigned();
            $table->foreign('estandarcomponente_id')->references('id')->on('estandarcomponentes')->onDelete('cascade');
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
        Schema::dropIfExists('aprendizajes');
    }
}
