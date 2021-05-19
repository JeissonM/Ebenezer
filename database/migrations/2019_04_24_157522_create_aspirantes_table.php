<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAspirantesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('aspirantes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('foto')->nullable()->default('NO');
            $table->string('numero_documento', 15);
            $table->string('lugar_expedicion')->nullable();
            $table->date('fecha_expedicion')->nullable();
            $table->string('rh', 50)->nullable();
            $table->string('primer_nombre', 50);
            $table->string('segundo_nombre', 50)->nullable();
            $table->string('primer_apellido', 50);
            $table->string('segundo_apellido', 50)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->string('correo')->nullable();
            $table->string('direccion_residencia')->nullable();
            $table->string('barrio_residencia')->nullable();
            $table->string('user_change', 100);
            $table->string('estado',50)->default('INSCRITO');
            $table->integer('tipodoc_id')->unsigned();
            $table->foreign('tipodoc_id')->references('id')->on('tipodocs')->onDelete('cascade');
            $table->integer('sexo_id')->unsigned()->nullable();
            $table->foreign('sexo_id')->references('id')->on('sexos')->onDelete('cascade');
            $table->bigInteger('ciudad_id')->unsigned()->nullable(); //ciudad nacimiento
            $table->foreign('ciudad_id')->references('id')->on('ciudads')->onDelete('cascade');
            $table->bigInteger('periodoacademico_id')->unsigned(); //periodo de convocatoria
            $table->foreign('periodoacademico_id')->references('id')->on('periodoacademicos')->onDelete('cascade');
            $table->bigInteger('grado_id')->unsigned(); //grado al que aspira
            $table->foreign('grado_id')->references('id')->on('grados')->onDelete('cascade');
            $table->bigInteger('unidad_id')->unsigned(); //unidad academica a la que aspira
            $table->foreign('unidad_id')->references('id')->on('unidads')->onDelete('cascade');
            $table->integer('estrato_id')->unsigned();
            $table->foreign('estrato_id')->references('id')->on('estratos')->onDelete('cascade');
            $table->bigInteger('jornada_id')->unsigned();
            $table->foreign('jornada_id')->references('id')->on('jornadas')->onDelete('cascade');
            $table->bigInteger('convocatoria_id')->unsigned()->nullable();
            $table->foreign('convocatoria_id')->references('id')->on('convocatorias')->onDelete('cascade');
            $table->bigInteger('circunscripcion_id')->unsigned();
            $table->foreign('circunscripcion_id')->references('id')->on('circunscripcions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('aspirantes');
    }

}
