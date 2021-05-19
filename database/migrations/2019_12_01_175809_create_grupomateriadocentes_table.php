<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrupomateriadocentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupomateriadocentes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_change', 100);
            $table->bigInteger('gradomateria_id')->unsigned();
            $table->foreign('gradomateria_id')->references('id')->on('gradomaterias')->onDelete('cascade');
            $table->bigInteger('docente_id')->unsigned()->nullable();
            $table->foreign('docente_id')->references('id')->on('docentes')->onDelete('cascade');
            $table->bigInteger('grupo_id')->unsigned();
            $table->foreign('grupo_id')->references('id')->on('grupos')->onDelete('cascade');
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
        Schema::dropIfExists('grupomateriadocentes');
    }
}
