<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtunidadevaluacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctunidadevaluacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('evaluacionacademica_id')->unsigned();
            $table->foreign('evaluacionacademica_id')->references('id')->on('evaluacionacademicas')->onDelete('cascade');
            $table->bigInteger('ctunidad_id')->unsigned();
            $table->foreign('ctunidad_id')->references('id')->on('ctunidads')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('ctunidadevaluacions');
    }
}
