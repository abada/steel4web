<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeRomaneioEtapaAndTipoEstagiosTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('romaneio_etapa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('romaneio_id')->unsigned();
            $table->foreign('romaneio_id')->references('id')->on('romaneios')->onDelete('cascade');
            $table->integer('etapa_id')->unsigned();
            $table->foreign('etapa_id')->references('id')->on('etapas')->onDelete('cascade');   
        });

      Schema::create('tiposestagios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descricao');
            $table->string('obs')->nullable();     
        });

      Schema::table('romaneios', function($table){
            $table->dropForeign('romaneios_etapa_id_foreign');
            $table->dropColumn('etapa_id');
            $table->dropForeign('romaneios_subetapa_id_foreign');
            $table->dropColumn('subetapa_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('romaneio_etapa', function (Blueprint $table) {
            $table->dropForeign('romaneio_etapa_romaneio_id_foreign');
            $table->dropForeign('romaneio_etapa_etapa_id_foreign');
        });
        Schema::drop('romaneio_etapa');

        Schema::drop('tiposestagios');

         Schema::table('romaneios', function($table){
            $table->integer('etapa_id')->unsigned();
            $table->foreign('etapa_id')->references('id')->on('etapas')->onDelete('cascade');
            $table->integer('subetapa_id')->unsigned();
            $table->foreign('subetapa_id')->references('id')->on('subetapas')->onDelete('cascade');
        });
    }
}
