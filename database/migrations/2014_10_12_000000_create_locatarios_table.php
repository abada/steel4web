<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocatariosTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('locatarios', function (Blueprint $table) {
			$table->increments('id');
			$table->string('razao', 255)->nullable();
			$table->string('fantasia', 255)->nullable();
			$table->boolean('tipo')->nullable();
			$table->string('documento', 255)->nullable();
			$table->string('inscricao', 255)->nullable();
			$table->string('fone', 255)->nullable();
			$table->text('cidade')->nullable();
			$table->string('endereco', 255)->nullable();
			$table->string('cep', 255)->nullable();
			$table->string('email', 255)->nullable();
			$table->boolean('status')->nullable();

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('locatarios');
	}
}
