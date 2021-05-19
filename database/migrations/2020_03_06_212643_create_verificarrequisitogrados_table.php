<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerificarrequisitogradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verificarrequisitogrados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_change', 100);
            $table->unsignedBigInteger('estudiante_id');
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');
            $table->unsignedBigInteger('asignarrequisitogrado_id');
            $table->foreign('asignarrequisitogrado_id')->references('id')->on('asignarrequisitogrados')->onDelete('cascade');
            $table->unsignedBigInteger('periodoacademico_id');
            $table->foreign('periodoacademico_id')->references('id')->on('periodoacademicos')->onDelete('cascade');
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
        Schema::dropIfExists('verificarrequisitogrados');
    }
}
