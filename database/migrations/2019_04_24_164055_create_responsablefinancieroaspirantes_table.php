<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsablefinancieroaspirantesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('responsablefinancieroaspirantes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('direccion_trabajo');
            $table->string('telefono_trabajo');
            $table->string('puesto_trabajo')->nullable();
            $table->string('empresa_labora')->nullable();
            $table->string('jefe_inmediato')->nullable();
            $table->string('telefono_jefe')->nullable();
            $table->text('descripcion_trabajador_independiente')->nullable();
            $table->bigInteger('ocupacion_id')->unsigned()->nullable();
            $table->foreign('ocupacion_id')->references('id')->on('ocupacions')->onDelete('cascade');
            $table->bigInteger('personanatural_id')->unsigned();
            $table->foreign('personanatural_id')->references('id')->on('personanaturals')->onDelete('cascade');
            $table->bigInteger('aspirante_id')->unsigned();
            $table->foreign('aspirante_id')->references('id')->on('aspirantes')->onDelete('cascade');
            $table->string('user_change', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('responsablefinancieroaspirantes');
    }

}
