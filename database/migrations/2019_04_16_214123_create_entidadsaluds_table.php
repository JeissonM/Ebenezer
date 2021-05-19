<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntidadsaludsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('entidadsaluds', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('codigo', 100);
            $table->string('nombre', 100);
            $table->string('tipoentidad', 30);
            $table->string('sector', 30)->nullable();
            $table->string('acronimo', 50)->nullable();
            $table->string('estado', 10)->default('ACTIVO');
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
        Schema::dropIfExists('entidadsaluds');
    }

}
