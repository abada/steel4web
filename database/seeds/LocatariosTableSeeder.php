<?php

use App\Locatario;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class LocatariosTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		if (env('DB_CONNECTION') == 'mysql') {
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		}

		$locatario = new Locatario;

		if (env('DB_CONNECTION') == 'mysql') {
			DB::table($locatario->getTable())->truncate();
		} elseif (env('DB_CONNECTION') == 'sqlite') {
			DB::statement('DELETE FROM ' . $locatario->getTable());
		} else {
			//For PostgreSQL or anything else
			DB::statement('TRUNCATE TABLE ' . $locatario->getTable() . ' CASCADE');
		}

		$faker = Faker::create('pt_BR');
		$faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));
		$faker->addProvider(new \Faker\Provider\pt_BR\Address($faker));
		// $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
		$faker->addProvider(new \Faker\Provider\en_US\PhoneNumber($faker));
		$faker->addProvider(new \Faker\Provider\pt_BR\Company($faker));
		$faker->addProvider(new \Faker\Provider\Lorem($faker));
		$faker->addProvider(new \Faker\Provider\Internet($faker));

		$locatarios_data = [
			array(
				'razao' => 'Locatário 1',
				'fantasia' => 'Locatário 1',
				'tipo' => false,
				'documento' => NULL,
				'inscricao' => NULL,
				'fone' => '(51) 3719-1086',
				'cidade' => 'Santa Cruz do Sul - RS',
				'endereco' => 'Av. Felisberto B. de Moraes 80 - distrito Industrial',
				'cep' => '96835-645',
				'email' => 'admin@locatario1.com',
				'status' => false,
			),
			array(
				'razao' => 'Locatário 2',
				// 'razao' => $faker->firstName() . " " . $faker->lastName(),
				'fantasia' => $faker->company(),
				'tipo' => false,
				'documento' => NULL,
				'inscricao' => NULL,
				'fone' => $faker->phoneNumber(),
				'cidade' => $faker->city(),
				'endereco' => $faker->address(),
				'cep' => '95320-000',
				'email' => 'admin@locatario2.com',
				'status' => false,
			)];

		$locatario->insert($locatarios_data);

		if (env('DB_CONNECTION') == 'mysql') {
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		}
	}
}
