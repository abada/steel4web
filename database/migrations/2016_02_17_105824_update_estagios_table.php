<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateEstagiosTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('estagios', function (Blueprint $table) {
			$table->string('rgb')->after('tipo')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('estagios', function (Blueprint $table) {
			$table->dropColumn('rgb');
		});
	}
}
