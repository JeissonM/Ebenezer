<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentecompetenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('componentecompetencias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('componente_id')->unsigned();
            $table->foreign('componente_id')->references('id')->on('componentes')->onDelete('cascade');
            $table->bigInteger('competencia_id')->unsigned();
            $table->foreign('competencia_id')->references('id')->on('competencias')->onDelete('cascade');
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
        Schema::dropIfExists('componentecompetencias');
    }
}
