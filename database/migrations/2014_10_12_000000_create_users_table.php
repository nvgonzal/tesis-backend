<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('ap_paterno');
            $table->string('ap_materno');
            $table->string('nombre_completo');
            $table->string('celular');
            $table->string('telefono_fijo');
            $table->string('tipo_usuario');
            $table->string('rut')->unique();

            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
