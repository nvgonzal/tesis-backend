<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGruasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gruas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patente');
            $table->string('tipo');
            $table->string('marca');
            $table->string('modelo');

            $table->string('id_empresa')->unsigned();
            $table->softDeletes();

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
        Schema::dropIfExists('gruas');
    }
}
