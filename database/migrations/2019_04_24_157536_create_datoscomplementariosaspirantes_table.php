<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatoscomplementariosaspirantesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('datoscomplementariosaspirantes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('padres_separados')->nullable()->default('NO'); //SI, NO
            $table->string('iglesia_asiste')->nullable();
            $table->string('pastor')->nullable();
            $table->string('discapacidad')->nullable()->default('NO'); //NO, SI: CUAL?
            $table->string('familias_en_accion')->nullable()->default('NO'); //SI, NO
            $table->string('poblacion_victima_conflicto')->nullable()->default('NO'); //SI, NO
            $table->string('desplazado')->nullable()->default('NO'); //SI, NO
            $table->string('colegio_procedencia')->nullable();
            $table->string('compromiso_adquirido')->nullable()->default('NO'); //SI, NO
            $table->string('user_change', 100);
            $table->integer('etnia_id')->unsigned()->nullable();
            $table->foreign('etnia_id')->references('id')->on('etnias')->onDelete('cascade');
            $table->bigInteger('conquienvive_id')->unsigned()->nullable();
            $table->foreign('conquienvive_id')->references('id')->on('conquienvives')->onDelete('cascade');
            $table->bigInteger('rangosisben_id')->unsigned()->nullable();
            $table->foreign('rangosisben_id')->references('id')->on('rangosisbens')->onDelete('cascade');
            $table->integer('entidadsalud_id')->unsigned()->nullable();
            $table->foreign('entidadsalud_id')->references('id')->on('entidadsaluds')->onDelete('cascade');
            $table->bigInteger('situacionanioanterior_id')->unsigned();
            $table->foreign('situacionanioanterior_id')->references('id')->on('situacionanioanteriors')->onDelete('cascade');
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
    public function down() {
        Schema::dropIfExists('datoscomplementariosaspirantes');
    }

}
