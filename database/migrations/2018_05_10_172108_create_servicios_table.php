<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_empresa')->unsigned();
            $table->integer('id_chofer')->unsigned();
            $table->integer('id_cliente')->unsigned();
            $table->integer('id_grua')->unsigned();
            $table->boolean('alta_gama');
            $table->string('patente_vehiculo');
            $table->string('marca');
            $table->string('modelo');
            $table->string('color');
            $table->string('ubicacion');
            $table->string('destino');
            $table->integer('precio_final');
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
        Schema::dropIfExists('servicios');
    }
}
