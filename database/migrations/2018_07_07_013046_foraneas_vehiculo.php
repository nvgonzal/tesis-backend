<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForaneasVehiculo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            $table->foreign('id_cliente')->references('id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            $table->dropForeign(['id_cliente']);
        });
    }
}
