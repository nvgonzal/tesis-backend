<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ColumasDolarPrecioServicio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servicios', function (Blueprint $table){
            $table->dropColumn('precio_final');
        });
        Schema::table('servicios', function (Blueprint $table) {
            $table->float('precio_dolar')->nullable();
            $table->float('precio_pesos')->nullable();
            $table->float('precio_final')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('servicios', function (Blueprint $table){
            $table->dropColumn('precio_dolar');
            $table->dropColumn('precio_pesos');
            $table->dropColumn('precio_final');
        });
        Schema::table('servicios', function (Blueprint $table) {
            $table->integer('precio_final')->nullable();
        });
    }
}
