<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLocatarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('handles', function($table)
        {
            $table->integer('romaneio_id')->unsigned();
            $table->foreign('romaneio_id')->references('id')->on('romaneios')->onDelete('cascade');
        });

        Schema::table('locatarios', function($table)
        {
            $table->string('IPexterno')->nullable();
            $table->string('usuarioFTP')->nullable();
            $table->string('senhaFTP')->nullable();
            $table->string('portaFTP')->nullable();
            $table->string('IPinterno')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('handles', function (Blueprint $table) {
            $table->dropColumn('romaneio_id');
            $table->dropForeign('handles_romaneio_id_foreign');
        });

       Schema::table('locatarios', function (Blueprint $table) {
            $table->dropColumn('IPexterno');
            $table->dropColumn('usuarioFTP');
            $table->dropColumn('senhaFTP');
            $table->dropColumn('portaFTP');
            $table->dropColumn('IPinterno');
        });
    }
}

