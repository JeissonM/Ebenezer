<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSistemaevaluacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sistemaevaluacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 150);
            $table->double('nota_inicial')->default(0);
            $table->double('nota_final')->default(0);
            $table->double('nota_aprobatoria')->default(0);
            $table->string('estado', 50)->default('EN DESUSO'); //EN DESUSO, ACTUAL
            $table->string('user_change', 100);
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
        Schema::dropIfExists('sistemaevaluacions');
    }
}
