<?php

use App\Cliente;
use App\Contato;
use App\Etapa;
use App\Locatario;
use App\Obra;
use App\Subetapa;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class Steel4webTablesSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		if (env('DB_CONNECTION') == 'mysql') {
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		}

		if (env('DB_CONNECTION') == 'mysql') {
			DB::table(config('access.assigned_roles_table'))->truncate();
		} elseif (env('DB_CONNECTION') == 'sqlite') {
			DB::statement('DELETE FROM ' . config('access.assigned_roles_table'));
		} else {
			//For PostgreSQL or anything else
			DB::statement('TRUNCATE TABLE ' . config('access.assigned_roles_table') . ' CASCADE');
		}

		$faker = Faker::create('pt_BR');
		$faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));
		$faker->addProvider(new \Faker\Provider\pt_BR\Address($faker));
		// $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
		$faker->addProvider(new \Faker\Provider\en_US\PhoneNumber($faker));
		$faker->addProvider(new \Faker\Provider\pt_BR\Company($faker));
		$faker->addProvider(new \Faker\Provider\Lorem($faker));
		$faker->addProvider(new \Faker\Provider\Internet($faker));

		/* LOCATARIO */
		$locatario_data = [
			'razao' => $faker->firstName() . " " . $faker->lastName(),
			'fantasia' => $faker->company(),
			'tipo' => false,
			'documento' => NULL,
			'inscricao' => NULL,
			'fone' => $faker->phoneNumber(),
			'cidade' => $faker->city(),
			'endereco' => $faker->address(),
			'cep' => '95320-000',
			'email' => $faker->email(),
			'status' => false,
		];

		// DB::table('locatarios')->insert($locatarios);
		$locatario = Locatario::create($locatario_data);

		//Attach first user to locatario
		$user_model = config('auth.providers.users.model');
		$user_model = new $user_model;
		$user_model::first()->locatario_id = $locatario->id;

		echo "Locatario '" . $locatario->fantasia . "' criado com sucesso!\n";

		// CLIENTE
		$cliente_data = [
			'razao' => $faker->company(),
			'fantasia' => $faker->company(),
			'documento' => NULL,
			'inscricao' => NULL,
			'fone' => $faker->phoneNumber(),
			'endereco' => $faker->address(),
			'cep' => '95320-000',
			'responsavel' => $faker->firstName() . " " . $faker->lastName(),
			'email' => $faker->email(),
			'site' => '',
			'user_id' => $user_model::first()->id,
			'locatario_id' => $locatario->id,
		];
		$cliente = Cliente::create($cliente_data);

		echo "Cliente  '" . $cliente->fantasia . "'' criado com sucesso!\n";

		$obra_data = [
			'codigo' => $faker->phoneNumber(),
			'nome' => 'Obra teste',
			'descricao' => 'Descritivo da obra Teste',
			'cidade' => 'New York',
			'endereco' => $faker->address(),
			'cep' => '95320-000',
			'cliente_id' => $cliente->id,
			'gerenciadoraid' => NULL,
			'calculistaid' => NULL,
			'detalhamentoid' => NULL,
			'montagemid' => NULL,
			'status' => true,
			'user_id' => $user_model::first()->id,
			'locatario_id' => $locatario->id,
		];

		$obra = Obra::create($obra_data);

		echo "Obra  '" . $obra->nome . "' criada com sucesso!\n";

		$contato_data = [
			'razao' => $faker->company(),
			'fantasia' => $faker->company(),
			'tipo_id' => NULL,
			'documento' => NULL,
			'inscricao' => NULL,
			'fone' => $faker->phoneNumber(),
			'cidade' => $faker->city(),
			'endereco' => $faker->address(),
			'cep' => '95320-000',
			'responsavel' => NULL,
			'email' => $faker->email(),
			'site' => NULL,
			'cliente_id' => $cliente->id,
			'user_id' => $user_model::first()->id,
			'locatario_id' => $locatario->id,
		];
		$contato = Contato::create($contato_data);
		$contato->obras()->attach($obra->id);
		echo "Contato  '" . $contato->fantasia . "'' vinculado a obra '" . $obra->nome . "'' com sucesso!\n";

		$contato_data = [
			'razao' => $faker->company(),
			'fantasia' => $faker->company(),
			'tipo_id' => NULL,
			'documento' => NULL,
			'inscricao' => NULL,
			'fone' => $faker->phoneNumber(),
			'cidade' => $faker->city(),
			'endereco' => $faker->address(),
			'cep' => '95320-000',
			'responsavel' => NULL,
			'email' => $faker->email(),
			'site' => NULL,
			'cliente_id' => $cliente->id,
			'user_id' => $user_model::first()->id,
			'locatario_id' => $locatario->id,
		];
		$contato = Contato::create($contato_data);
		$contato->obras()->attach($obra->id);
		echo "Contato  '" . $contato->fantasia . "'' vinculado a obra '" . $obra->nome . "'' com sucesso!\n";

		$etapa_data = [
			'codigo' => $faker->phoneNumber(),
			'peso' => 10234,
			'observacao' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi nulla fuga quod sed, tempora quo cumque! Consectetur optio labore tenetur unde aliquam, harum eligendi delectus voluptatem. Alias voluptate tempore libero.',
			'obra_id' => $obra->id,
			'user_id' => $user_model::first()->id,
			'locatario_id' => $locatario->id,
		];

		$etapa = Etapa::create($etapa_data);

		echo "Etapa  " . $etapa->nome . " criada com sucesso!\n";

		// SUBETAPAS
		$subetapas = array(
			array(
				'cod' => 'SUB-001',
				'peso' => '5500',
				'tiposubetapa_id' => NULL,
				'observacao' => 'Nada',
				'etapa_id' => $etapa->id,
				'user_id' => $user_model::first()->id,
				'locatario_id' => $locatario->id,
			),
			array(
				'cod' => 'SUB-002',
				'peso' => '6500',
				'tiposubetapa_id' => NULL,
				'observacao' => 'Teste de observação!',
				'etapa_id' => $etapa->id,
				'user_id' => $user_model::first()->id,
				'locatario_id' => $locatario->id,
			),
		);

		Subetapa::insert($subetapas);
		echo "2 Subbetapas adicionadas com sucesso!\n";

		if (env('DB_CONNECTION') == 'mysql') {
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		}
	}
}
