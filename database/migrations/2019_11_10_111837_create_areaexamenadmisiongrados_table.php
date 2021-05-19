<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaexamenadmisiongradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areaexamenadmisiongrados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('peso');
            $table->string('user_change', 100);
            $table->bigInteger('areaexamenadmision_id')->unsigned();
            $table->foreign('areaexamenadmision_id')->references('id')->on('areaexamenadmisions')->onDelete('cascade');
            $table->bigInteger('grado_id')->unsigned();
            $table->foreign('grado_id')->references('id')->on('grados')->onDelete('cascade');
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
        Schema::dropIfExists('areaexamenadmisiongrados');
    }
}
