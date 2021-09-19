<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTipodiscapacidadToDatoscomplementariosaspirantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('datoscomplementariosaspirantes', function (Blueprint $table) {
            $table->string('tipo_discapacidad')->nullable()->after('discapacidad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datoscomplementariosaspirantes', function (Blueprint $table) {
            //
        });
    }
}
