<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('email')->unique();
			$table->string('password', 60)->nullable();
			$table->string('confirmation_code');
			$table->boolean('confirmed')->default(config('access.users.confirm_email') ? false : true);
			$table->rememberToken();
			$table->integer('locatario_id')->nullable()->unsigned();
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default('0000-00-00 00:00');
			$table->softDeletes();
		});

		/* FOREIGN KEYS USERS */
		Schema::table('users', function (Blueprint $table) {
			$table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('users', function (Blueprint $table) {
			$table->dropForeign('users_locatario_id_foreign');
		});
		Schema::drop('users');
	}
}
