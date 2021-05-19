<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePadresestudiantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('padresestudiantes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numero_documento', 15);
            $table->string('lugar_expedicion')->nullable();
            $table->date('fecha_expedicion')->nullable();
            $table->string('primer_nombre', 50);
            $table->string('segundo_nombre', 50)->nullable();
            $table->string('primer_apellido', 50);
            $table->string('segundo_apellido', 50)->nullable();
            $table->string('vive', 5)->nullable()->default('SI'); //SI, NO
            $table->string('acudiente', 5)->nullable()->default('NO'); //SI, NO
            $table->string('direccion_residencia')->nullable();
            $table->string('barrio_residencia')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->string('correo')->nullable();
            $table->string('padre_madre')->default('PADRE');
            $table->integer('sexo_id')->unsigned()->nullable();
            $table->foreign('sexo_id')->references('id')->on('sexos')->onDelete('cascade');
            $table->integer('tipodoc_id')->unsigned();
            $table->foreign('tipodoc_id')->references('id')->on('tipodocs')->onDelete('cascade');
            $table->bigInteger('ocupacion_id')->unsigned()->nullable();
            $table->foreign('ocupacion_id')->references('id')->on('ocupacions')->onDelete('cascade');
            $table->bigInteger('estudiante_id')->unsigned();
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');
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
        Schema::dropIfExists('padresestudiantes');
    }
}
