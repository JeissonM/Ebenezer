<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForodiscusionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forodiscusions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo');
            $table->text('contenido');
            $table->string('user_change', 100);
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('grupomateriadocente_id')->unsigned();
            $table->foreign('grupomateriadocente_id')->references('id')->on('grupomateriadocentes')->onDelete('cascade');
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
        Schema::dropIfExists('forodiscusions');
    }
}
