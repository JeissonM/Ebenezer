<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPeriodoacademicoIdtoCeremonia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ceremonias', function (Blueprint $table) {
            $table->unsignedBigInteger('periodoacademico_id')->nullable()->after('jornada_id');
            $table->foreign('periodoacademico_id')->references('id')->on('periodoacademicos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ceremonias', function (Blueprint $table) {
            $table->dropColumn('periodoacademico_id');
        });
    }
}
