<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstandarcomponentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estandarcomponentes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('componente_id')->unsigned();
            $table->foreign('componente_id')->references('id')->on('componentes')->onDelete('cascade');
            $table->bigInteger('estandar_id')->unsigned();
            $table->foreign('estandar_id')->references('id')->on('estandars')->onDelete('cascade');
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
        Schema::dropIfExists('estandarcomponentes');
    }
}
