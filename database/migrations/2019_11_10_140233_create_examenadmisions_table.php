<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamenadmisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examenadmisions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('calificacion', 3, 1)->nullable();
            $table->text('anotaciones')->nullable();
            $table->string('soporte')->default('NO')->nullable();
            $table->string('user_change', 100);
            $table->string('estado')->default('PENDIENTE'); //PENDIENTE, REPROBADO, APROBADO
            $table->bigInteger('aspirante_id')->unsigned();
            $table->foreign('aspirante_id')->references('id')->on('aspirantes')->onDelete('cascade');
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
        Schema::dropIfExists('examenadmisions');
    }
}
