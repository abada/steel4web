<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateCronogramaprevTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('cronogramaPrev', function (Blueprint $table) {
			$table->integer('version')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('cronogramaPrev', function (Blueprint $table) {
			$table->dropColumn('version');
		});
	}
}
