<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonanaturalsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('personanaturals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('primer_nombre', 50);
            $table->string('segundo_nombre', 50)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('libreta_militar', 15)->nullable();
            $table->string('edad', 20)->nullable();
            $table->string('rh', 50)->nullable();
            $table->string('primer_apellido', 50);
            $table->string('segundo_apellido', 50)->nullable();
            $table->string('distrito_militar', 10)->nullable();
            $table->string('numero_pasaporte', 50)->nullable();
            $table->string('otra_nacionalidad', 30)->nullable();
            $table->string('clase_libreta', 100)->nullable();
            $table->string('fax', 20)->nullable();
            $table->string('ocupacion')->nullable();
            $table->string('profesion')->nullable();
            $table->string('nivel_estudio')->nullable();
            $table->string('user_change', 100);
            $table->bigInteger('ciudad_id')->unsigned()->nullable();
            $table->foreign('ciudad_id')->references('id')->on('ciudads')->onDelete('cascade');
            $table->integer('estado_id')->unsigned()->nullable();
            $table->foreign('estado_id')->references('id')->on('estados')->onDelete('cascade');
            $table->integer('pais_id')->unsigned()->nullable();
            $table->foreign('pais_id')->references('id')->on('pais')->onDelete('cascade');
            $table->bigInteger('persona_id')->unsigned();
            $table->foreign('persona_id')->references('id')->on('personas')->onDelete('cascade');
            $table->integer('sexo_id')->unsigned()->nullable();
            $table->foreign('sexo_id')->references('id')->on('sexos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('personanaturals');
    }

}
