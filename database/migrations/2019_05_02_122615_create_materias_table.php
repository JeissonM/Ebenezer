<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMateriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigomateria', 30)->unique();
            $table->string('nombre', 200)->required();
            $table->string('descripcion')->nullable();
            $table->enum('recuperable', ['SI', 'NO'])->default('SI');
            $table->enum('nivelable', ['SI', 'NO'])->default('SI');
            $table->bigInteger('area_id')->unsigned();
            $table->bigInteger('naturaleza_id')->unsigned()->nullable();
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
            $table->foreign('naturaleza_id')->references('id')->on('naturalezas')->onDelete('cascade');
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
        Schema::dropIfExists('materias');
    }
}
