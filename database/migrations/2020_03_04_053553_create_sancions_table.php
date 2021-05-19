<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSancionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sancions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('sancion');
            $table->date('fechainicio');
            $table->date('fechafin');
            $table->string('estado',30)->default('ACTIVA');
            $table->string('user_change', 100);
            $table->bigInteger('estudiante_id')->unsigned();
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');
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
        Schema::dropIfExists('sancions');
    }
}
