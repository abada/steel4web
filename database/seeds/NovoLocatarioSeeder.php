<?php

use App\Estagio;
use App\Locatario;
use App\Models\Access\User\User;
use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;

class NovoLocatarioSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$locatario = new Locatario;
		$locatario_data = array(
			'razao' => env('LOCATARIO_RAZAO', 'Locatário XXX'),
			'fantasia' => env('LOCATARIO_FANTASIA', 'Locatário XXX'),
			'tipo' => false,
			'documento' => env('LOCATARIO_DOCUMENTO', NULL),
			'inscricao' => env('LOCATARIO_INSCRICAO', NULL),
			'fone' => env('LOCATARIO_FONE', NULL),
			'cidade' => env('LOCATARIO_CIDADE', NULL),
			'endereco' => env('LOCATARIO_ENDERECO', NULL),
			'cep' => env('LOCATARIO_CEP', NULL),
			'email' => env('LOCATARIO_EMAIL', NULL),
			'status' => false,
			'IPexterno' => env('LOCATARIO_IPEXTERNO', NULL),
			'IPinterno' => env('LOCATARIO_IPINTERNO', NULL),
			'FTPusuario' => env('LOCATARIO_FTPUSUARIO', NULL),
			'FTPsenha' => env('LOCATARIO_FTPSENHA', NULL),
			'FTPporta' => env('LOCATARIO_FTPPORTA', NULL),
			'logo' => env('LOCATARIO_LOGO', NULL),
		);

		$locatario = $locatario->create($locatario_data);

		$user = new User;
		$user_data = array(
			'name' => 'Root',
			'email' => 'root@' . str_slug($locatario->fantasia) . '.com',
			'password' => bcrypt('rootgarcia69'),
			'confirmation_code' => md5(uniqid(mt_rand(), true)),
			'confirmed' => true,
			'locatario_id' => $locatario->id,
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
		);
		$user = $user->create($user_data);

		$estagios = explode(',', env('LOCATARIO_ESTAGIOS'));
		$i = 0;
		foreach ($estagios as $estagio) {
			list($est, $tipo) = explode(':', $estagio);
			$e = new Estagio;

			$e_data = array(
				'descricao' => $est,
				'ordem' => $i++,
				'tipo' => $tipo,
				'user_id' => $user->id,
				'locatario_id' => $locatario->id,
			);
			$e = $e->create($e_data);
		}

	}
}
