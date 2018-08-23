<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveDescrFoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('foto_daños', function (Blueprint $table) {
            $table->dropColumn('descripcion');
            $table->string('bucket_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('foto_daños', function (Blueprint $table) {
            $table->text('descripcion');
            $table->dropColumn('bucket_url');
        });
    }
}
