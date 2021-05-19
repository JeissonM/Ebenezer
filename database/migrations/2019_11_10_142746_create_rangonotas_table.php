<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRangonotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rangonotas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('valor_inicial', 3, 1);
            $table->double('valor_final', 3, 1);
            $table->string('valor_cualitativo');
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
        Schema::dropIfExists('rangonotas');
    }
}
