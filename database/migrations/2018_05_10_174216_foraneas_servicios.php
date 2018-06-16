<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForaneasServicios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servicios',function (Blueprint $table){
            $table->foreign('id_empresa')->references('id')->on('empresas');
            $table->foreign('id_chofer')->references('id')->on('choferes');
            $table->foreign('id_cliente')->references('id')->on('clientes');
            $table->foreign('id_grua')->references('id')->on('gruas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('servicios',function (Blueprint $table){
            $table->dropForeign(['id_empresa']);
            $table->dropForeign(['id_chofer']);
            $table->dropForeign(['id_cliente']);
            $table->dropForeign(['id_grua']);
        });
    }
}
