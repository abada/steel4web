<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCronogramasTables extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('cronogramaPrev', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('estagio_id')->nullable()->unsigned();
			$table->foreign('estagio_id')->references('id')->on('estagios')->onDelete('cascade');

			$table->integer('lote_id')->nullable()->unsigned();
			$table->foreign('lote_id')->references('id')->on('lotes')->onDelete('cascade');

			$table->date('data')->nullable();

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('locatario_id')->unsigned();
			$table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

			$table->timestamps();
		});

		Schema::create('cronogramaReal', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('estagio_id')->nullable()->unsigned();
			$table->foreign('estagio_id')->references('id')->on('estagios')->onDelete('cascade');

			$table->integer('lote_id')->nullable()->unsigned();
			$table->foreign('lote_id')->references('id')->on('lotes')->onDelete('cascade');

			$table->integer('handle_id')->nullable()->unsigned();
			$table->foreign('handle_id')->references('id')->on('handles')->onDelete('cascade');

			$table->date('data')->nullable();

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
	public function down() {
		Schema::table('cronogramaReal', function (Blueprint $table) {
			$table->dropForeign('cronogramaReal_estagio_id_foreign');
			$table->dropForeign('cronogramaReal_lote_id_foreign');
			$table->dropForeign('cronogramaReal_handle_id_foreign');
			$table->dropForeign('cronogramaReal_user_id_foreign');
			$table->dropForeign('cronogramaReal_locatario_id_foreign');
		});
		Schema::drop('cronogramaReal');

		Schema::table('cronogramaPrev', function (Blueprint $table) {
			$table->dropForeign('cronogramaPrev_estagio_id_foreign');
			$table->dropForeign('cronogramaPrev_lote_id_foreign');
			$table->dropForeign('cronogramaPrev_user_id_foreign');
			$table->dropForeign('cronogramaPrev_locatario_id_foreign');
		});
		Schema::drop('cronogramaPrev');
	}
}
