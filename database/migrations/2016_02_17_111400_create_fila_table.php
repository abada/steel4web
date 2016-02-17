<?php

use Illuminate\Database\Migrations\Migration;

class CreateFilaTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		// Schema::table('fila', function (Blueprint $table) {

		//     $table->bigIncrements('id');

		//     $table->longText('descricao')->nullable();
		//     $table->longText('arquivo')->nullable();
		//     $table->boolean('convertido')->default(false);

		//     $table->integer('importacao_id')->unsigned();
		//     $table->foreign('importacao_id')->references('id')->on('importacoes')->onDelete('cascade');
		//     $table->integer('user_id')->unsigned();
		//     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		//     $table->integer('locatario_id')->unsigned();
		//     $table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

		//     $table->timestamps();
		// });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		// Schema::table('fila', function (Blueprint $table) {
		//           $table->dropForeign('fila_importacao_id_foreign');
		// 	$table->dropForeign('fila_user_id_foreign');
		//           $table->dropForeign('fila_locatario_id_foreign')
		// });
		//       Schema::drop('fila');
	}
}
