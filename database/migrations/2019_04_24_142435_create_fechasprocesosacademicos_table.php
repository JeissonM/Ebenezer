<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFechasprocesosacademicosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('fechasprocesosacademicos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->string('user_change', 100);
            $table->bigInteger('procesosacademico_id')->unsigned();
            $table->foreign('procesosacademico_id')->references('id')->on('procesosacademicos')->onDelete('cascade');
            $table->bigInteger('periodoacademico_id')->unsigned();
            $table->foreign('periodoacademico_id')->references('id')->on('periodoacademicos')->onDelete('cascade');
            $table->bigInteger('unidad_id')->unsigned();
            $table->foreign('unidad_id')->references('id')->on('unidads')->onDelete('cascade');
            $table->bigInteger('jornada_id')->unsigned();
            $table->foreign('jornada_id')->references('id')->on('jornadas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('fechasprocesosacademicos');
    }

}
