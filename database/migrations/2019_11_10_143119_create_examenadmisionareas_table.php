<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamenadmisionareasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examenadmisionareas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('calificacion', 3, 1)->nullable();
            $table->string('user_change', 100);
            $table->bigInteger('areaexamenadmisiongrado_id')->unsigned();
            $table->foreign('areaexamenadmisiongrado_id')->references('id')->on('areaexamenadmisiongrados')->onDelete('cascade');
            $table->bigInteger('examenadmision_id')->unsigned();
            $table->foreign('examenadmision_id')->references('id')->on('examenadmisions')->onDelete('cascade');
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
        Schema::dropIfExists('examenadmisionareas');
    }
}
