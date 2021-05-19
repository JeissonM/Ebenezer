<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtunidadtemasubtemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctunidadtemasubtemas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo');
            $table->text('desarrollo');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('ctunidadtema_id')->unsigned();
            $table->foreign('ctunidadtema_id')->references('id')->on('ctunidadtemas')->onDelete('cascade');
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
        Schema::dropIfExists('ctunidadtemasubtemas');
    }
}
