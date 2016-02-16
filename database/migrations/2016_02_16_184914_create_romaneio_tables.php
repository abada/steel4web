<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRomaneioTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transportadoras', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nome')->nullable();
            $table->string('fone1')->nullable();
            $table->string('fone2')->nullable();
            $table->string('contato1')->nullable();
            $table->string('contato2')->nullable();
            $table->string('email')->nullable();
            $table->string('observacoes')->nullable();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('motoristas', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nome')->nullable();
            $table->string('fone1')->nullable();
            $table->string('fone2')->nullable();
            $table->string('caminhao')->nullable();
            $table->string('comprimento')->nullable();
            $table->string('observacoes')->nullable();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('romaneios', function (Blueprint $table) {
            $table->increments('id');

            $table->string('codigo')->nullable();
            $table->string('Nfs')->nullable();
            $table->string('data_saida')->nullable();
            $table->string('previsao_chegada')->nullable();
            $table->string('status')->nullable();
            $table->string('observacoes')->nullable();

            $table->integer('motorista_id')->unsigned();
            $table->foreign('motorista_id')->references('id')->on('motoristas')->onDelete('cascade');

            $table->integer('transportadora_id')->unsigned();
            $table->foreign('transportadora_id')->references('id')->on('transportadoras')->onDelete('cascade');

            $table->integer('subetapa_id')->unsigned();
            $table->foreign('subetapa_id')->references('id')->on('subetapas')->onDelete('cascade');

            $table->integer('etapa_id')->unsigned();
            $table->foreign('etapa_id')->references('id')->on('etapas')->onDelete('cascade');

            $table->integer('obra_id')->unsigned();
            $table->foreign('obra_id')->references('id')->on('obras')->onDelete('cascade');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('locatario_id')->unsigned();
            $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

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
        Schema::table('transportadoras', function (Blueprint $table) {
            $table->dropForeign('transportadoras_user_id_foreign');
            $table->dropForeign('transportadoras_locatario_id_foreign');
        });
        Schema::drop('transportadoras');

        Schema::table('motoristas', function (Blueprint $table) {
            $table->dropForeign('motoristas_user_id_foreign');
            $table->dropForeign('motoristas_locatario_id_foreign');
        });
        Schema::drop('motoristas');

        Schema::table('romaneios', function (Blueprint $table) {
            $table->dropForeign('romaneios_motorista_id_foreign');
            $table->dropForeign('romaneios_transportadora_id_foreign');
            $table->dropForeign('romaneios_subetapa_id_foreign');
            $table->dropForeign('romaneios_etapa_id_foreign');
            $table->dropForeign('romaneios_obra_id_foreign');
            $table->dropForeign('romaneios_user_id_foreign');
            $table->dropForeign('romaneios_locatario_id_foreign');
        });
        Schema::drop('romaneios');
    }
}
