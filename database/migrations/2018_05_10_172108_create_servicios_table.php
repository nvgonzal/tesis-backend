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
            $table->unsignedInteger('id_empresa')->nullable();
            $table->unsignedInteger('id_chofer')->nullable();
            $table->unsignedInteger('id_cliente');
            $table->unsignedInteger('id_grua')->nullable();
            $table->boolean('alta_gama');
            $table->string('patente_vehiculo');
            $table->string('marca');
            $table->string('modelo');
            $table->string('color');
            $table->string('ubicacion');
            $table->string('destino');
            $table->integer('precio_final')->nullable();
            $table->enum('estado',['creado','tomado','pagado','finalizado'])->default('creado');
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
