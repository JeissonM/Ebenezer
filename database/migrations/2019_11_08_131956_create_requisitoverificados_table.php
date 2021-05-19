<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisitoverificadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisitoverificados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('aspirante_id')->unsigned();
            $table->foreign('aspirante_id')->references('id')->on('aspirantes')->onDelete('cascade');
            $table->bigInteger('documentoanexo_id')->unsigned();
            $table->foreign('documentoanexo_id')->references('id')->on('documentoanexos')->onDelete('cascade');
            $table->bigInteger('procesosacademico_id')->unsigned();
            $table->foreign('procesosacademico_id')->references('id')->on('procesosacademicos')->onDelete('cascade');
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
        Schema::dropIfExists('requisitoverificados');
    }
}
