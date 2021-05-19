<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrupousuariosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('grupousuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->string('user_change', 100);
            $table->timestamps();
        });
        Schema::create('grupousuario_pagina', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('grupousuario_id')->unsigned();
            $table->integer('pagina_id')->unsigned();
            $table->foreign('grupousuario_id')->references('id')->on('grupousuarios')->onDelete('cascade');
            $table->foreign('pagina_id')->references('id')->on('paginas')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('grupousuario_modulo', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('grupousuario_id')->unsigned();
            $table->integer('modulo_id')->unsigned();
            $table->foreign('grupousuario_id')->references('id')->on('grupousuarios')->onDelete('cascade');
            $table->foreign('modulo_id')->references('id')->on('modulos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('grupousuarios');
    }

}
