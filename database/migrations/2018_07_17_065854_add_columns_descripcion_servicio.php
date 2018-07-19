<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsDescripcionServicio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servicios', function (Blueprint $table) {
            $table->text('descripcion');
            $table->text('descripcion_chofer')->nullable();
            $table->float('evaluacion_cliente')->nullable();
            $table->float('evaluacion_empresa')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('servicios', function (Blueprint $table) {
            $table->dropColumn('descripcion');
            $table->dropColumn('descripcion_chofer');
            $table->dropColumn('evaluacion_cliente');
            $table->dropColumn('evaluacion_empresa');
        });
    }
}
