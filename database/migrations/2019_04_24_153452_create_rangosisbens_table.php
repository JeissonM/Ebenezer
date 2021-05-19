<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRangosisbensTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('rangosisbens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('etiqueta');
            $table->string('descripcion')->nullable();
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
        Schema::dropIfExists('rangosisbens');
    }

}
