<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateLocatarioTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('handles', function ($table) {
			$table->integer('romaneio_id')->unsigned()->nullable();
			$table->foreign('romaneio_id')->references('id')->on('romaneios')->onDelete('cascade');
		});

		Schema::table('locatarios', function ($table) {
			$table->string('IPexterno')->nullable();
			$table->string('IPinterno')->nullable();
			$table->string('FTPusuario')->nullable();
			$table->string('FTPsenha')->nullable();
			$table->string('FTPporta')->nullable();
			$table->string('logo')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('handles', function (Blueprint $table) {
			$table->dropColumn('romaneio_id');
			$table->dropForeign('handles_romaneio_id_foreign');
		});

		Schema::table('locatarios', function (Blueprint $table) {
			$table->dropColumn('IPexterno');
			$table->dropColumn('IPinterno');
			$table->dropColumn('FTPusuario');
			$table->dropColumn('FTPsenha');
			$table->dropColumn('FTPporta');
			$table->dropColumn('logo');
		});
	}
}