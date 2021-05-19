<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('personas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipopersona', 20);
            $table->string('direccion', 100)->nullable();
            $table->string('mail', 200)->nullable();
            $table->string('celular', 20)->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('numero_documento', 15);
            $table->string('lugar_expedicion', 50)->nullable();
            $table->date('fecha_expedicion')->nullable();
            $table->string('nombrecomercial', 200)->nullable();
            $table->string('regimen', 200)->nullable();
            $table->string('user_change', 100);
            $table->integer('tipodoc_id')->unsigned();
            $table->foreign('tipodoc_id')->references('id')->on('tipodocs')->onDelete('cascade');
            $table->integer('pais_id')->unsigned()->nullable();
            $table->foreign('pais_id')->references('id')->on('pais')->onDelete('cascade');
            $table->integer('estado_id')->unsigned()->nullable();
            $table->foreign('estado_id')->references('id')->on('estados')->onDelete('cascade');
            $table->bigInteger('ciudad_id')->unsigned()->nullable();
            $table->foreign('ciudad_id')->references('id')->on('ciudads')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('personas');
    }

}
