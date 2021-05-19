<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcudienteestudiantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acudienteestudiantes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('estudiante_id')->unsigned();
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');
            $table->bigInteger('personanatural_id')->unsigned();
            $table->foreign('personanatural_id')->references('id')->on('personanaturals')->onDelete('cascade');
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
        Schema::dropIfExists('acudienteestudiantes');
    }
}
