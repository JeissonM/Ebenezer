<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtunidadtemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctunidadtemas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo');
            $table->text('introduccion');
            $table->string('duracion');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('ctunidad_id')->unsigned();
            $table->foreign('ctunidad_id')->references('id')->on('ctunidads')->onDelete('cascade');
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
        Schema::dropIfExists('ctunidadtemas');
    }
}
