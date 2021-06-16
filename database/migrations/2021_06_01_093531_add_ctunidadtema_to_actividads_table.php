<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCtunidadtemaToActividadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('actividads', function (Blueprint $table) {
            $table->unsignedBigInteger('ctunidadtema_id')->after('materia_id')->nullable();
            $table->foreign('ctunidadtema_id')->references('id')->on('ctunidadtemas')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('actividads', function (Blueprint $table) {
            //
        });
    }
}
