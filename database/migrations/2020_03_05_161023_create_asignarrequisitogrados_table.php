<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsignarrequisitogradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignarrequisitogrados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_change', 100);
            $table->unsignedBigInteger('requisitogrado_id');
            $table->foreign('requisitogrado_id')->references('id')->on('requisitogrados')->onDelete('cascade');
            $table->unsignedBigInteger('grado_id');
            $table->foreign('grado_id')->references('id')->on('grados')->onDelete('cascade');
            $table->unsignedBigInteger('unidad_id');
            $table->foreign('unidad_id')->references('id')->on('unidads')->onDelete('cascade');
            $table->unsignedBigInteger('jornada_id');
            $table->foreign('jornada_id')->references('id')->on('jornadas')->onDelete('cascade');
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
        Schema::dropIfExists('asignarrequisitogrados');
    }
}
