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
            $table->unsignedInteger('id_empresa');
            $table->unsignedInteger('id_chofer');
            $table->unsignedInteger('id_cliente');
            $table->unsignedInteger('id_grua');
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
