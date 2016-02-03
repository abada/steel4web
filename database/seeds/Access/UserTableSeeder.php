<?php

use App\Locatario;
use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class UserTableSeeder
 */
class UserTableSeeder extends Seeder {
	public function run() {
		if (env('DB_CONNECTION') == 'mysql') {
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		}

		if (env('DB_CONNECTION') == 'mysql') {
			DB::table(config('access.users_table'))->truncate();
		} elseif (env('DB_CONNECTION') == 'sqlite') {
			DB::statement('DELETE FROM ' . config('access.users_table'));
		} else {
			//For PostgreSQL or anything else
			DB::statement('TRUNCATE TABLE ' . config('access.users_table') . ' CASCADE');
		}

		$locatarios = Locatario::all();

		foreach ($locatarios as $locatario) {
			if ($locatario->fantasia == 'Metalfoort') {
				$users = [
					'name' => 'MetalFoort',
					'email' => 'projeto@metalfoort.com.br',
					'password' => bcrypt('1234'),
					'confirmation_code' => md5(uniqid(mt_rand(), true)),
					'confirmed' => true,
					'locatario_id' => $locatario->id,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now(),
				];
			} else {
				$users = [
					[
						'name' => 'Admin',
						'email' => 'admin@locatario' . $locatario->id . '.com',
						'password' => bcrypt('1234'),
						'confirmation_code' => md5(uniqid(mt_rand(), true)),
						'confirmed' => true,
						'locatario_id' => $locatario->id,
						'created_at' => Carbon::now(),
						'updated_at' => Carbon::now(),
					],
					[
						'name' => 'User',
						'email' => 'user@locatario' . $locatario->id . '.com',
						'password' => bcrypt('1234'),
						'confirmation_code' => md5(uniqid(mt_rand(), true)),
						'confirmed' => true,
						'locatario_id' => $locatario->id,
						'created_at' => Carbon::now(),
						'updated_at' => Carbon::now(),
					],

				];

			}

			DB::table(config('access.users_table'))->insert($users);
		}

		if (env('DB_CONNECTION') == 'mysql') {
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		}
	}
}