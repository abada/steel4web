<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContatoObraTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('contato_obra', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('contato_id')->nullable()->unsigned();
			$table->foreign('contato_id')->references('id')->on('contatos')->onDelete('cascade');

			$table->integer('obra_id')->nullable()->unsigned();
			$table->foreign('obra_id')->references('id')->on('obras')->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('contato_obra', function (Blueprint $table) {
			$table->dropForeign('contato_obra_contato_id_foreign');
			$table->dropForeign('contato_obra_obra_id_foreign');
		});
		Schema::drop('contato_obra');
	}
}
