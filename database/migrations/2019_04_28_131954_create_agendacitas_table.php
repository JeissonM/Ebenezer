<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendacitasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('agendacitas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fecha');
            $table->integer('horainicio');
            $table->integer('horafin');
            $table->string('estado')->default('DISPONIBLE');
            $table->bigInteger('periodounidad_id')->unsigned();
            $table->foreign('periodounidad_id')->references('id')->on('periodounidads')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('agendacitas');
    }

}
