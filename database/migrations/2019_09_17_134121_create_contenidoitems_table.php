<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContenidoitemsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('contenidoitems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('contenido');
            $table->bigInteger('itemcontenidomateria_id')->unsigned();
            $table->foreign('itemcontenidomateria_id')->references('id')->on('itemcontenidomaterias')->onDelete('cascade');
            $table->bigInteger('materia_id')->unsigned();
            $table->foreign('materia_id')->references('id')->on('materias')->onDelete('cascade');
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
        Schema::dropIfExists('contenidoitems');
    }

}
