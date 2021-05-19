<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForodiscusionrespuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forodiscusionrespuestas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('contenido');
            $table->string('user_change', 100);
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('forodiscusion_id')->unsigned();
            $table->foreign('forodiscusion_id')->references('id')->on('forodiscusions')->onDelete('cascade');
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
        Schema::dropIfExists('forodiscusionrespuestas');
    }
}
