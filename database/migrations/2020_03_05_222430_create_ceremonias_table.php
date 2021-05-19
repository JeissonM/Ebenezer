<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCeremoniasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ceremonias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo');
            $table->string('lugar');
            $table->string('user_change', 100);
            $table->dateTime('fechahorainicio');
            $table->dateTime('fechahorafin');
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
        Schema::dropIfExists('ceremonias');
    }
}
