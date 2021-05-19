<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcudientesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('acudientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('aspirante_id')->unsigned();
            $table->foreign('aspirante_id')->references('id')->on('aspirantes')->onDelete('cascade');
            $table->bigInteger('personanatural_id')->unsigned();
            $table->foreign('personanatural_id')->references('id')->on('personanaturals')->onDelete('cascade');
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
        Schema::dropIfExists('acudientes');
    }

}
