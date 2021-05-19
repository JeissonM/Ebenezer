<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identificacion')->unique();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('estado', 50)->default('ACTIVO');
            $table->string('user_change', 100);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('grupousuario_user', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('grupousuario_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('grupousuario_id')->references('id')->on('grupousuarios')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }

}
