<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJornadasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('jornadas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descripcion', 50);
            $table->string('horainicio', 5)->nullable();
            $table->string('horafin', 5)->nullable();
            $table->string('jornadasnies', 8)->nullable();
            $table->string('findesemana', 2)->nullable();
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
        Schema::dropIfExists('jornadas');
    }

}
