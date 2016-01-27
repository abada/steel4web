<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSteel4webTables extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		// Schema::create('cidades', function(Blueprint $table) {
		//         $table->increments('cidadeid');
		//         $table->string('nome', 255);
		//         $table->integer('estado');
		//     });

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

		Schema::create('clientes', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('tipo')->nullable();
			$table->string('razao', 255)->nullable();
			$table->string('fantasia', 255)->nullable();
			$table->string('documento', 255)->nullable();
			$table->string('inscricao', 255)->nullable();
			$table->string('fone', 255)->nullable();
			$table->string('endereco', 255)->nullable();
			$table->string('cep', 255)->nullable();
			$table->string('responsavel', 255)->nullable();
			$table->string('email', 255)->nullable();
			$table->string('site', 255)->nullable();
			$table->text('cidade')->nullable();
			// $table->integer('cliente')->nullable();
			// $table->integer('construtora')->nullable();
			// $table->integer('gerenciadora')->nullable();
			// $table->integer('calculista')->nullable();
			// $table->integer('detalhamento')->nullable();
			// $table->integer('montagem')->nullable();
			// $table->string('outro', 255)->nullable();
			// $table->dateTime('data');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('locatario_id')->unsigned();
			$table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

			$table->timestamps();
		});

		Schema::create('tiposcontatos', function (Blueprint $table) {
			$table->increments('id');
			$table->text('descricao')->nullable();

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('locatario_id')->unsigned();
			$table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

			$table->timestamps();
		});

		Schema::create('contatos', function (Blueprint $table) {
			$table->increments('id');
			$table->string('razao', 255)->nullable();
			$table->string('fantasia', 255)->nullable();

			$table->integer('tipo_id')->nullable()->unsigned();
			$table->foreign('tipo_id')->references('id')->on('tiposcontatos')->onDelete('set null');

			$table->string('documento', 255)->nullable();
			$table->string('inscricao', 255)->nullable();
			$table->string('fone', 255)->nullable();
			$table->text('cidade')->nullable();
			$table->string('endereco', 255)->nullable();
			$table->string('cep', 255)->nullable();
			$table->string('responsavel', 255)->nullable();
			$table->string('email', 255)->nullable();
			$table->string('site', 255)->nullable();
			$table->text('crea')->nullable();

			$table->integer('cliente_id')->unsigned();
			$table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('locatario_id')->unsigned();
			$table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

			$table->timestamps();
		});
		// Schema::create('estados', function(Blueprint $table) {
		//         $table->increments('estadoid');
		//         $table->string('nome', 255);
		//         $table->string('uf', 5);
		//     });

		Schema::create('logs', function (Blueprint $table) {
			$table->increments('id');
			$table->text('acao');
			$table->text('query')->nullable();
			$table->dateTime('data');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('locatario_id')->unsigned();
			$table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');
		});

		Schema::create('obras', function (Blueprint $table) {
			$table->increments('id');
			$table->string('codigo', 255)->nullable();
			$table->string('nome', 255);
			$table->text('descricao')->nullable();
			$table->text('cidade');
			$table->string('endereco', 255);
			$table->string('cep', 255);

			$table->integer('cliente_id')->nullable()->unsigned();
			$table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null');

			$table->integer('status')->nullable();

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('locatario_id')->unsigned();
			$table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

			$table->timestamps();
		});

		Schema::create('etapas', function (Blueprint $table) {
			$table->increments('id');
			$table->string('codigo', 255);
			$table->integer('peso')->nullable();

			// $table->boolean('estruturaPrincipal')->nullable();
			// $table->boolean('estruturaSecundaria')->nullable();
			// $table->boolean('telhasCobertura')->nullable();
			// $table->boolean('telhasFechamento')->nullable();
			// $table->boolean('calhas')->nullable();
			// $table->boolean('rufosArremates')->nullable();
			// $table->boolean('steelDeck')->nullable();
			// $table->boolean('gradesPiso')->nullable();
			// $table->boolean('escadas')->nullable();
			// $table->boolean('corrimao')->nullable();
			// $table->string('outro', 255)->nullable();
			$table->text('observacao')->nullable();

			$table->integer('obra_id')->nullable()->unsigned();
			$table->foreign('obra_id')->references('id')->on('obras')->onDelete('cascade');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('locatario_id')->unsigned();
			$table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

			$table->timestamps();
		});

		Schema::create('tipossubetapas', function (Blueprint $table) {
			$table->increments('id');
			$table->text('descricao')->nullable();

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('locatario_id')->unsigned();
			$table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

			$table->timestamps();
		});
		Schema::create('subetapas', function (Blueprint $table) {
			$table->increments('id');
			$table->string('cod', 255);
			$table->integer('peso');
			$table->integer('tiposubetapa_id')->nullable()->unsigned();
			$table->foreign('tiposubetapa_id')->references('id')->on('tipossubetapas')->onDelete('set null');

			$table->text('observacao');

			$table->integer('etapa_id')->nullable()->unsigned();
			$table->foreign('etapa_id')->references('id')->on('etapas')->onDelete('set null');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('locatario_id')->unsigned();
			$table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

			$table->timestamps();
		});

		Schema::create('tiposestagios', function (Blueprint $table) {
			$table->increments('id');
			$table->text('decricao');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('locatario_id')->unsigned();
			$table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

			$table->timestamps();
		});
		Schema::create('estagios', function (Blueprint $table) {
			$table->increments('id');
			$table->text('decricao');
			$table->integer('ordem');

			$table->integer('tipoestagio_id')->nullable()->unsigned();
			$table->foreign('tipoestagio_id')->references('id')->on('tiposestagios')->onDelete('set null');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('locatario_id')->unsigned();
			$table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

			$table->timestamps();
		});

		Schema::create('lotes', function (Blueprint $table) {
			$table->increments('id');
			$table->text('descricao')->nullable();

			$table->integer('obra_id')->nullable()->unsigned();
			$table->foreign('obra_id')->references('id')->on('obras')->onDelete('cascade');

			$table->integer('etapa_id')->nullable()->unsigned();
			$table->foreign('etapa_id')->references('id')->on('etapas')->onDelete('cascade');

			$table->integer('subetapa_id')->nullable()->unsigned();
			$table->foreign('subetapa_id')->references('id')->on('subetapas')->onDelete('cascade');

			$table->boolean('producao');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('locatario_id')->unsigned();
			$table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

			$table->timestamps();
		});

		Schema::create('medicoes', function (Blueprint $table) {
			$table->increments('id');
			$table->string('descricao', 50)->nullable();
			$table->string('periodo', 50)->nullable();
			$table->string('montador', 50)->nullable();
			$table->string('obs', 255)->nullable();

			$table->integer('etapa_id')->nullable()->unsigned();
			$table->foreign('etapa_id')->references('id')->on('etapas')->onDelete('cascade');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('locatario_id')->unsigned();
			$table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

			$table->timestamps();
		});

		Schema::create('importacoes', function (Blueprint $table) {

			$table->increments('id');
			$table->text('descricao')->nullable();

			$table->integer('cliente_id')->nullable()->unsigned();
			$table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null');

			$table->integer('obra_id')->nullable()->unsigned();
			$table->foreign('obra_id')->references('id')->on('obras')->onDelete('set null');

			$table->integer('etapa_id')->nullable()->unsigned();
			$table->foreign('etapa_id')->references('id')->on('etapas')->onDelete('set null');

			$table->integer('subetapa_id')->nullable()->unsigned();
			$table->foreign('subetapa_id')->references('id')->on('subetapas')->onDelete('set null');

			$table->string('dbf2d', 255)->nullable();

			// $table->string('dbf3d', 255)->nullable();
			$table->string('ifc', 255)->nullable();
			$table->string('fbx', 255)->nullable();
			// $table->string('dbf2d_orig', 255)->nullable();
			// $table->string('dbf3d_orig', 255)->nullable();
			$table->string('ifc_orig', 255)->nullable();
			$table->string('fbx_orig', 255)->nullable();
			$table->string('erro_debug', 255)->nullable();

			$table->integer('importacaoNr');
			$table->text('observacoes')->nullable();
			$table->integer('sentido')->default('1');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('locatario_id')->unsigned();
			$table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

			$table->timestamps();
		});

		Schema::create('handles', function (Blueprint $table) {
			$table->increments('id');
			$table->string('HANDLE', 255)->nullable();
			$table->integer('FLG_REC')->nullable();
			$table->string('NUM_COM', 255)->nullable();
			$table->string('DES_COM', 255)->nullable();
			$table->string('LOT_COM', 255)->nullable();
			$table->string('DLO_COM', 255)->nullable();
			$table->string('CLI_COM', 255)->nullable();
			$table->string('IND_COM', 255)->nullable();
			$table->string('DT1_COM', 255)->nullable();
			$table->string('DT2_COM', 255)->nullable();
			$table->string('NUM_DIS', 255)->nullable();
			$table->string('DES_DIS', 255)->nullable();
			$table->string('NOM_DIS', 255)->nullable();
			$table->string('REV_DIS', 255)->nullable();
			$table->string('DAT_DIS', 10)->nullable();
			$table->string('TRA_PEZ', 255)->nullable();
			$table->string('SBA_PEZ', 255)->nullable();
			$table->string('DES_SBA', 255)->nullable();
			$table->string('TIP_PEZ', 255)->nullable();
			$table->string('MAR_PEZ', 255)->nullable();
			$table->string('MBU_PEZ', 255)->nullable();
			$table->string('DES_PEZ', 255)->nullable();
			$table->string('POS_PEZ', 255)->nullable();
			$table->string('NOT_PEZ', 255)->nullable();
			$table->string('ING_PEZ', 255)->nullable();
			$table->string('MAX_LEN', 255)->nullable();
			$table->integer('QTA_PEZ')->nullable();
			$table->string('QT1_PEZ', 255)->nullable();
			$table->string('MCL_PEZ', 255)->nullable();
			$table->string('COD_PEZ', 255)->nullable();
			$table->string('COS_PEZ', 255)->nullable();
			$table->string('NOM_PRO', 255)->nullable();
			$table->float('LUN_PRO')->nullable();
			$table->float('LAR_PRO')->nullable();
			$table->float('SPE_PRO')->nullable();
			$table->string('MAT_PRO', 255)->nullable();
			$table->string('TIP_BUL', 255)->nullable();
			$table->string('DIA_BUL', 255)->nullable();
			$table->string('LUN_BUL', 255)->nullable();
			$table->string('PRB_BUL', 255)->nullable();
			$table->float('PUN_LIS')->nullable();
			$table->float('SUN_LIS')->nullable();
			$table->string('PRE_LIS', 255)->nullable();
			$table->string('FLG_DWG', 255)->nullable();

			$table->integer('obra_id')->nullable()->unsigned();
			$table->foreign('obra_id')->references('id')->on('obras')->onDelete('set null');

			$table->integer('lote_id')->nullable()->unsigned();
			$table->foreign('lote_id')->references('id')->on('lotes')->onDelete('set null');

			$table->integer('estagio_id')->nullable()->unsigned();
			$table->foreign('estagio_id')->references('id')->on('estagios')->onDelete('set null');

			$table->integer('etapa_id')->nullable()->unsigned();
			$table->foreign('etapa_id')->references('id')->on('etapas')->onDelete('set null');

			$table->integer('subetapa_id')->nullable()->unsigned();
			$table->foreign('subetapa_id')->references('id')->on('subetapas')->onDelete('set null');

			$table->string('GROUP', 255)->nullable();
			$table->string('CATE', 255)->nullable();

			$table->integer('importacao_id')->nullable()->unsigned();
			$table->foreign('importacao_id')->references('id')->on('importacoes')->onDelete('set null');

			// $table->string('preparacao_id')->nullable();    //$table->string('fkpreparacao', 255)->nullable();

			$table->integer('medicao_id')->nullable()->unsigned();
			$table->foreign('medicao_id')->references('id')->on('medicoes')->onDelete('set null'); // $table->integer('fkmedicao')->nullable();

			$table->string('X', 255)->nullable();
			$table->string('Y', 255)->nullable();
			$table->string('Z', 255)->nullable();
			$table->string('A', 255)->nullable();
			$table->string('B', 255)->nullable();

			// $table->index('fkmedicao_idx');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('locatario_id')->unsigned();
			$table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

			$table->timestamps();
		});

		Schema::create('temp_handles', function (Blueprint $table) {
			$table->increments('id');
			$table->string('HANDLE', 255)->nullable();
			$table->integer('FLG_REC')->nullable();
			$table->string('NUM_COM', 255)->nullable();
			$table->string('DES_COM', 255)->nullable();
			$table->string('LOT_COM', 255)->nullable();
			$table->string('DLO_COM', 255)->nullable();
			$table->string('CLI_COM', 255)->nullable();
			$table->string('IND_COM', 255)->nullable();
			$table->string('DT1_COM', 255)->nullable();
			$table->string('DT2_COM', 255)->nullable();
			$table->string('NUM_DIS', 255)->nullable();
			$table->string('DES_DIS', 255)->nullable();
			$table->string('NOM_DIS', 255)->nullable();
			$table->string('REV_DIS', 255)->nullable();
			$table->string('DAT_DIS', 10)->nullable();
			$table->string('TRA_PEZ', 255)->nullable();
			$table->string('SBA_PEZ', 255)->nullable();
			$table->string('DES_SBA', 255)->nullable();
			$table->string('TIP_PEZ', 255)->nullable();
			$table->string('MAR_PEZ', 255)->nullable();
			$table->string('MBU_PEZ', 255)->nullable();
			$table->string('DES_PEZ', 255)->nullable();
			$table->string('POS_PEZ', 255)->nullable();
			$table->string('NOT_PEZ', 255)->nullable();
			$table->string('ING_PEZ', 255)->nullable();
			$table->string('MAX_LEN', 255)->nullable();
			$table->integer('QTA_PEZ')->nullable();
			$table->string('QT1_PEZ', 255)->nullable();
			$table->string('MCL_PEZ', 255)->nullable();
			$table->string('COD_PEZ', 255)->nullable();
			$table->string('COS_PEZ', 255)->nullable();
			$table->string('NOM_PRO', 255)->nullable();
			$table->float('LUN_PRO')->nullable();
			$table->float('LAR_PRO')->nullable();
			$table->float('SPE_PRO')->nullable();
			$table->string('MAT_PRO', 255)->nullable();
			$table->string('TIP_BUL', 255)->nullable();
			$table->string('DIA_BUL', 255)->nullable();
			$table->string('LUN_BUL', 255)->nullable();
			$table->string('PRB_BUL', 255)->nullable();
			$table->float('PUN_LIS')->nullable();
			$table->float('SUN_LIS')->nullable();
			$table->string('PRE_LIS', 255)->nullable();
			$table->string('FLG_DWG', 255)->nullable();

			$table->integer('obra_id')->nullable()->unsigned();
			$table->foreign('obra_id')->references('id')->on('obras')->onDelete('set null');

			$table->integer('lote_id')->nullable()->unsigned();
			$table->foreign('lote_id')->references('id')->on('lotes')->onDelete('set null');

			$table->integer('estagio_id')->nullable()->unsigned();
			$table->foreign('estagio_id')->references('id')->on('estagios')->onDelete('set null');

			$table->integer('etapa_id')->nullable()->unsigned();
			$table->foreign('etapa_id')->references('id')->on('etapas')->onDelete('set null');

			$table->integer('subetapa_id')->nullable()->unsigned();
			$table->foreign('subetapa_id')->references('id')->on('subetapas')->onDelete('set null');

			$table->string('GROUP', 255)->nullable();
			$table->string('CATE', 255)->nullable();

			$table->integer('importacao_id')->nullable()->unsigned();
			$table->foreign('importacao_id')->references('id')->on('importacoes')->onDelete('set null');

			// $table->string('preparacao_id')->nullable();    //$table->string('fkpreparacao', 255)->nullable();

			$table->integer('medicao_id')->nullable()->unsigned();
			$table->foreign('medicao_id')->references('id')->on('medicoes')->onDelete('set null'); // $table->integer('fkmedicao')->nullable();

			$table->string('X', 255)->nullable();
			$table->string('Y', 255)->nullable();
			$table->string('Z', 255)->nullable();
			$table->string('A', 255)->nullable();
			$table->string('B', 255)->nullable();

			// $table->index('fkmedicao_idx');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('locatario_id')->unsigned();
			$table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

			$table->timestamps();
		});

		// Schema::create('tiposusuarios', function(Blueprint $table) {
		//         $table->increments('id');
		//         $table->string('nome', 255);
		//         $table->string('descricao', 255)->nullable();

		//         $table->integer('user_id')->unsigned();
		//     });

		// Schema::create('usuariosadmin', function(Blueprint $table) {
		//         $table->increments('usuarioAdminid');
		//         $table->string('nome', 255);
		//         $table->string('senha', 255);
		//         $table->string('email', 255);
		//         $table->boolean('status');

		//         $table->integer('user_id')->unsigned();
		//     });

		// Schema::create('usuarioslocatarios', function(Blueprint $table) {
		//         $table->increments('usuariouser_id');
		//         $table->string('nome', 255);
		//         $table->string('senha', 255);
		//         $table->string('email', 255);
		//         $table->boolean('status');
		//         $table->integer('tiposusuarios_id');

		//         $table->integer('user_id')->unsigned();
		//     });

		/*--------------------------*/

		// Schema::create('dm_cadastros', function(Blueprint $table) {
		//         $table->increments('id');
		//         $table->string('nome', 100)->nullable();
		//         $table->string('empresa', 100)->nullable();
		//         $table->string('email', 100)->nullable();
		//         $table->string('fone1', 255)->nullable();
		//         $table->string('fone2', 255)->nullable();
		//         $table->string('fone3', 255)->nullable();
		//         $table->string('obs', 255)->nullable();
		//         $table->string('obra', 255)->nullable();
		//         $table->string('medicao', 255)->nullable();
		//     });

		// Schema::create('dm_conjuntosproduzidos', function(Blueprint $table) {
		//         $table->increments('id');
		//         $table->integer('id_obra')->nullable();
		//         $table->integer('id_lote')->nullable();
		//         $table->integer('id_conj')->nullable();
		//         $table->integer('id_user')->nullable();
		//         $table->string('turno', 50)->nullable();
		//         $table->integer('qtd_produzida')->nullable();
		//         $table->string('estagios', 50)->nullable();
		//         $table->string('data', 20)->nullable();
		//         $table->string('hora', 20)->nullable();
		//         $table->integer('id_trabalhador')->nullable();
		//         $table->string('id_grp', 50)->nullable();
		//     });

		// Schema::create('dm_ctcs', function(Blueprint $table) {
		//         $table->increments('id');
		//         $table->integer('obra_id');
		//         $table->string('n', 20);
		//         $table->string('tipo', 10);
		//         $table->integer('etapa');
		//         $table->string('contatos', 200);
		//         $table->string('descricao', 5000);
		//         $table->string('titulo', 200);
		//         $table->integer('dia');
		//         $table->integer('mes');
		//         $table->integer('ano');
		//     });

		// Schema::create('dm_estagios', function(Blueprint $table) {
		//         $table->increments('id');
		//         $table->integer('n_ordem')->nullable();
		//         $table->string('titulo', 255)->nullable();
		//         $table->string('nome_campo_pecacronograma', 255)->nullable();
		//     });

		// Schema::create('dm_romaneios', function(Blueprint $table) {
		//     $table->increments('id');
		//     $table->string('nome', 255)->nullable();
		//     $table->integer('id_obra')->nullable();
		//     $table->integer('id_lote')->nullable();
		//     $table->string('transportador', 255)->nullable();
		//     $table->string('motorista', 255)->nullable();
		//     $table->string('placa', 255)->nullable();
		//     $table->string('tipo_truck', 255)->nullable();
		//     $table->string('fone1', 255)->nullable();
		//     $table->string('fone2', 255)->nullable();
		//     $table->date('saida')->nullable();
		//     $table->date('chegada')->nullable();
		//     $table->string('notafiscal', 255)->nullable();
		//     $table->string('array_lotes', 2000)->nullable();
		//     $table->string('status', 50)->nullable();
		//     $table->integer('fkhandle')->nullable();
		//     $table->string('grp', 255)->nullable();
		//     $table->integer('qtd')->nullable();
		//     $table->string('fone_transp', 15)->nullable();
		//     $table->string('contato_transp', 100)->nullable();
		//     $table->float('comprimento_caminhao')->nullable();
		//     $table->string('obs', 255)->nullable();
		// });

		// Schema::create('resolucoes', function(Blueprint $table) {
		//         $table->increments('id');
		//         $table->string('nome', 255)->nullable();
		//         $table->integer('largura')->nullable();
		//         $table->integer('altura')->nullable();
		//         $table->string('link', 255)->nullable();
		//     });

		// Schema::create('cjtocrono', function(Blueprint $table) {
		//         $table->increments('id')->unsigned();
		//         $table->integer('lote_id')->nullable()->unsigned();
		//         $table->integer('obra_id')->nullable()->unsigned();
		//         $table->date('dataprev_pcp')->nullable();
		//         $table->date('datareal_pcp')->nullable();
		//         $table->date('dataprev_preparacao')->nullable();
		//         $table->date('datareal_preparacao')->nullable();
		//         $table->date('dataprev_gabarito')->nullable();
		//         $table->date('datareal_gabarito')->nullable();
		//         $table->date('dataprev_solda')->nullable();
		//         $table->date('datareal_solda')->nullable();
		//         $table->date('dataprev_pintura')->nullable();
		//         $table->date('datareal_pintura')->nullable();
		//         $table->date('dataprev_expedicao')->nullable();
		//         $table->date('datareal_expedicao')->nullable();
		//         $table->date('dataprev_montagem')->nullable();
		//         $table->date('datareal_montagem')->nullable();
		//         $table->date('dataprev_entrega')->nullable();
		//         $table->date('datareal_entrega')->nullable();
		//         $table->integer('peca_id')->nullable()->unsigned();
		//         $table->integer('status')->nullable();
		//         $table->integer('etapa_id')->nullable()->unsigned();
		//         $table->integer('pcp_qtd')->nullable();
		//         $table->integer('preparacao_qtd')->nullable();
		//         $table->integer('gabarito_qtd')->nullable();
		//         $table->integer('solda_qtd')->nullable();
		//         $table->integer('pintura_qtd')->nullable();
		//         $table->integer('expedicao_qtd')->nullable();
		//         $table->integer('montagem_qtd')->nullable();
		//         $table->integer('entrega_qtd')->nullable();
		//         $table->integer('medicao_id')->nullable()->unsigned();

		//         $table->integer('user_id')->unsigned();
		//     });

		// Schema::create('clientes', function(Blueprint $table) {
		//         $table->increments('id');
		//         $table->string('nome', 256)->nullable();
		//         $table->string('razaosocial', 255)->nullable();
		//         $table->string('nomefantasia', 255)->nullable();
		//         $table->string('site', 255)->nullable();
		//         $table->string('rua', 128)->nullable();
		//         $table->string('bairro', 128)->nullable();
		//         $table->string('cidade', 128)->nullable();
		//         $table->integer('numero')->nullable();
		//         $table->string('uf', 2)->nullable();
		//         $table->string('cep', 20)->nullable();
		//         $table->integer('tipo')->nullable();
		//         $table->text('obs_tipo')->nullable();
		//         $table->text('obs')->nullable();
		//         $table->string('cnpj', 30)->nullable();
		//         $table->string('comp', 255)->nullable();
		//         $table->string('fone1', 50)->nullable();
		//         $table->string('fone2', 50)->nullable();
		//         $table->string('fone3', 50)->nullable();
		//         $table->string('email', 255)->nullable();
		//     });

		// Schema::create('clientescontatos', function(Blueprint $table) {
		//         $table->integer('cliente_id')->nullable();
		//         $table->string('nome', 255)->nullable();
		//         $table->string('telefone', 16)->nullable();
		//         $table->string('celular', 16)->nullable();
		//         $table->string('email', 128)->nullable();
		//         $table->string('setor', 128)->nullable();
		//         $table->text('obs')->nullable();
		//     });

		// Schema::create('cronograma', function(Blueprint $table) {
		//         $table->increments('id');
		//         $table->integer('TIPO')->nullable();
		//         $table->integer('FKESTAGIO')->nullable();
		//         $table->date('DATAPREV')->nullable();
		//     });

		// Schema::create('dbf2d', function(Blueprint $table) {
		//         $table->integer('PROJETO')->nullable();
		//         $table->integer('FLG_REC')->nullable();
		//         $table->string('NUM_COM', 255)->nullable();
		//         $table->string('DES_COM', 255)->nullable();
		//         $table->string('LOT_COM', 255)->nullable();
		//         $table->string('DLO_COM', 255)->nullable();
		//         $table->string('CLI_COM', 255)->nullable();
		//         $table->string('IND_COM', 255)->nullable();
		//         $table->string('DT1_COM', 255)->nullable();
		//         $table->string('DT2_COM', 255)->nullable();
		//         $table->string('NUM_DIS', 255)->nullable();
		//         $table->string('DES_DIS', 255)->nullable();
		//         $table->string('NOM_DIS', 255)->nullable();
		//         $table->string('REV_DIS', 255)->nullable();
		//         $table->string('DAT_DIS', 10)->nullable();
		//         $table->string('TRA_PEZ', 255)->nullable();
		//         $table->string('SBA_PEZ', 255)->nullable();
		//         $table->string('DES_SBA', 255)->nullable();
		//         $table->string('TIP_PEZ', 255)->nullable();
		//         $table->string('MAR_PEZ', 255)->nullable();
		//         $table->string('MBU_PEZ', 255)->nullable();
		//         $table->string('DES_PEZ', 255)->nullable();
		//         $table->string('POS_PEZ', 255)->nullable();
		//         $table->string('NOT_PEZ', 255)->nullable();
		//         $table->string('ING_PEZ', 255)->nullable();
		//         $table->string('MAX_LEN', 255)->nullable();
		//         $table->integer('QTA_PEZ')->nullable();
		//         $table->string('QT1_PEZ', 255)->nullable();
		//         $table->string('MCL_PEZ', 255)->nullable();
		//         $table->string('COD_PEZ', 255)->nullable();
		//         $table->string('COS_PEZ', 255)->nullable();
		//         $table->string('NOM_PRO', 255)->nullable();
		//         $table->float('LUN_PRO')->nullable();
		//         $table->float('LAR_PRO')->nullable();
		//         $table->float('SPE_PRO')->nullable();
		//         $table->string('MAT_PRO', 255)->nullable();
		//         $table->string('TIP_BUL', 255)->nullable();
		//         $table->string('DIA_BUL', 255)->nullable();
		//         $table->string('LUN_BUL', 255)->nullable();
		//         $table->string('PRB_BUL', 255)->nullable();
		//         $table->float('PUN_LIS')->nullable();
		//         $table->float('SUN_LIS')->nullable();
		//         $table->string('PRE_LIS', 255)->nullable();
		//         $table->string('FLG_DWG', 255)->nullable();
		//         $table->integer('obra_id')->nullable();
		//         $table->increments('id');
		//         $table->integer('etapa_id')->nullable();
		//         $table->integer('importacao_id')->nullable();
		//     });

		// Schema::create('dbf3d', function(Blueprint $table) {
		//         $table->increments('id');
		//         $table->string('HANDLE', 255)->nullable();
		//         $table->integer('OBRA_id')->nullable();
		//         $table->integer('FKETAPA')->nullable();
		//         $table->string('CATEPERFIL', 255)->nullable();
		//         $table->string('PERFIL', 255)->nullable();
		//         $table->string('GRP', 255)->nullable();
		//         $table->string('MATERIAL', 255)->nullable();
		//         $table->string('ACABAMENTO', 255)->nullable();
		//         $table->string('POSICAO', 255)->nullable();
		//         $table->string('MARCA', 255)->nullable();
		//         $table->integer('FKIMPORTACAO')->nullable();
		//         $table->string('GRP1', 255)->nullable();
		//         $table->string('GRP2', 255)->nullable();
		//         $table->string('TEMP_INFO', 255)->nullable();
		//     });

		// Schema::create('estagioproducao', function(Blueprint $table) {
		//         $table->increments('id');
		//         $table->string('DESCRICAO', 255)->nullable();
		//         $table->integer('FKTIPO')->nullable();
		//         $table->integer('ORDEM')->nullable();
		//     });

		// Schema::create('etapa', function(Blueprint $table) {
		//         $table->increments('id');
		//         $table->string('codigo', 64)->nullable();
		//         $table->string('identificacao', 256)->nullable();
		//         $table->integer('obra_id')->nullable();
		//         $table->integer('cliente_id')->nullable();
		//         $table->text('obs')->nullable();

		//         $table->integer('user_id')->unsigned();
		//     });

		// Schema::create('grupotrabalho', function(Blueprint $table) {
		//         $table->increments('id');
		//         $table->string('DESCRICAO', 255)->nullable();
		//     });

		// Schema::create('handles', function(Blueprint $table) {
		//         $table->integer('PROJETO')->nullable();
		//         $table->string('HANDLE', 255)->nullable();
		//         $table->integer('FLG_REC')->nullable();
		//         $table->string('NUM_COM', 255)->nullable();
		//         $table->string('DES_COM', 255)->nullable();
		//         $table->string('LOT_COM', 255)->nullable();
		//         $table->string('DLO_COM', 255)->nullable();
		//         $table->string('CLI_COM', 255)->nullable();
		//         $table->string('IND_COM', 255)->nullable();
		//         $table->string('DT1_COM', 255)->nullable();
		//         $table->string('DT2_COM', 255)->nullable();
		//         $table->string('NUM_DIS', 255)->nullable();
		//         $table->string('DES_DIS', 255)->nullable();
		//         $table->string('NOM_DIS', 255)->nullable();
		//         $table->string('REV_DIS', 255)->nullable();
		//         $table->string('DAT_DIS', 10)->nullable();
		//         $table->string('TRA_PEZ', 255)->nullable();
		//         $table->string('SBA_PEZ', 255)->nullable();
		//         $table->string('DES_SBA', 255)->nullable();
		//         $table->string('TIP_PEZ', 255)->nullable();
		//         $table->string('MAR_PEZ', 255)->nullable();
		//         $table->string('MBU_PEZ', 255)->nullable();
		//         $table->string('DES_PEZ', 255)->nullable();
		//         $table->string('POS_PEZ', 255)->nullable();
		//         $table->string('NOT_PEZ', 255)->nullable();
		//         $table->string('ING_PEZ', 255)->nullable();
		//         $table->string('MAX_LEN', 255)->nullable();
		//         $table->integer('QTA_PEZ')->nullable();
		//         $table->string('QT1_PEZ', 255)->nullable();
		//         $table->string('MCL_PEZ', 255)->nullable();
		//         $table->string('COD_PEZ', 255)->nullable();
		//         $table->string('COS_PEZ', 255)->nullable();
		//         $table->string('NOM_PRO', 255)->nullable();
		//         $table->float('LUN_PRO')->nullable();
		//         $table->float('LAR_PRO')->nullable();
		//         $table->float('SPE_PRO')->nullable();
		//         $table->string('MAT_PRO', 255)->nullable();
		//         $table->string('TIP_BUL', 255)->nullable();
		//         $table->string('DIA_BUL', 255)->nullable();
		//         $table->string('LUN_BUL', 255)->nullable();
		//         $table->string('PRB_BUL', 255)->nullable();
		//         $table->float('PUN_LIS')->nullable();
		//         $table->float('SUN_LIS')->nullable();
		//         $table->string('PRE_LIS', 255)->nullable();
		//         $table->string('FLG_DWG', 255)->nullable();
		//         $table->integer('obra_id')->nullable();
		//         $table->increments('id');
		//         $table->integer('lote_id')->nullable();
		//         $table->integer('estagio_id')->nullable();
		//         $table->string('grp', 255)->nullable();
		//         $table->string('nome_file1', 255)->nullable();
		//         $table->string('nome_file2', 255)->nullable();
		//         $table->string('nome_file3', 255)->nullable();
		//         $table->string('nome_file4', 255)->nullable();
		//         $table->integer('etapa_id')->nullable();
		//         $table->string('CATEPERFIL', 255)->nullable();
		//         $table->integer('importacao_id')->nullable();
		//         $table->string('fkpreparacao', 255)->nullable();
		//         $table->integer('fkmedicao')->nullable();
		//         $table->index('fkmedicao_idx');
		//     });

		// Schema::create('importacao', function(Blueprint $table) {
		//         $table->increments('id');
		//         $table->string('descricao', 255)->nullable();
		//         $table->integer('obra_id')->nullable();
		//         $table->integer('etapa_id')->nullable();
		//         $table->integer('cliente_id')->nullable();
		//         $table->integer('fkusuario')->nullable();
		//         $table->date('data')->nullable();
		//         $table->string('dbf2d', 255)->nullable();
		//         $table->string('dbf3d', 255)->nullable();
		//         $table->string('ifc', 255)->nullable();
		//         $table->string('fbx', 255)->nullable();
		//         $table->string('dbf2d_orig', 255)->nullable();
		//         $table->string('dbf3d_orig', 255)->nullable();
		//         $table->string('ifc_orig', 255)->nullable();
		//         $table->string('fbx_orig', 255)->nullable();
		//         $table->string('erro_debug', 255)->nullable();
		//     });

		// Schema::create('lotes', function(Blueprint $table) {
		//         $table->increments('id');
		//         $table->string('descricao', 255)->nullable();
		//         $table->integer('obra_id')->nullable();
		//         $table->integer('estagio_id')->nullable();
		//         $table->integer('etapa_id')->nullable();
		//         $table->string('producao', 1)->nullable();
		//     });

		// Schema::create('lotecronograma', function(Blueprint $table) {
		//         $table->increments('id');
		//         $table->integer('estagio_id')->nullable();
		//         $table->date('dataprev')->nullable();
		//         $table->date('datareal')->nullable();
		//         $table->integer('lotes')->nullable();
		//     });

		// Schema::create('lotepecas', function(Blueprint $table) {
		//         $table->increments('id');
		//         $table->integer('lotes')->nullable();
		//         $table->integer('peca')->nullable();
		//     });

		// Schema::create('obras', function(Blueprint $table) {
		//         $table->increments('id');
		//         $table->string('descricao', 256)->nullable();
		//         $table->date('dataini')->nullable();
		//         $table->date('datafim')->nullable();
		//         $table->integer('cliente_id')->nullable();
		//         $table->text('obs')->nullable();
		//         $table->string('status_online', 255)->nullable();

		//         $table->integer('user_id')->unsigned();
		//     });

		// Schema::create('pecacronograma', function(Blueprint $table) {
		//         $table->increments('id');
		//         $table->integer('lote_id')->nullable();
		//         $table->integer('obra_id')->nullable();
		//         $table->boolean('pcp')->nullable();
		//         $table->date('dataprev_pcp')->nullable();
		//         $table->date('datareal_pcp')->nullable();
		//         $table->boolean('preparacao')->nullable();
		//         $table->date('dataprev_preparacao')->nullable();
		//         $table->date('datareal_preparacao')->nullable();
		//         $table->boolean('gabarito')->nullable();
		//         $table->date('dataprev_gabarito')->nullable();
		//         $table->date('datareal_gabarito')->nullable();
		//         $table->boolean('solda')->nullable();
		//         $table->date('dataprev_solda')->nullable();
		//         $table->date('datareal_solda')->nullable();
		//         $table->boolean('pintura')->nullable();
		//         $table->date('dataprev_pintura')->nullable();
		//         $table->date('datareal_pintura')->nullable();
		//         $table->boolean('expedicao')->nullable();
		//         $table->date('dataprev_expedicao')->nullable();
		//         $table->date('datareal_expedicao')->nullable();
		//         $table->boolean('montagem')->nullable();
		//         $table->date('dataprev_montagem')->nullable();
		//         $table->date('datareal_montagem')->nullable();
		//         $table->boolean('entrega')->nullable();
		//         $table->date('dataprev_entrega')->nullable();
		//         $table->date('datareal_entrega')->nullable();
		//         $table->integer('peca_id')->nullable();
		//         $table->integer('status')->nullable();
		//         $table->integer('etapa_id')->nullable();
		//         $table->integer('pcp_qtd')->nullable();
		//         $table->integer('preparacao_qtd')->nullable();
		//         $table->integer('gabarito_qtd')->nullable();
		//         $table->integer('solda_qtd')->nullable();
		//         $table->integer('pintura_qtd')->nullable();
		//         $table->integer('expedicao_qtd')->nullable();
		//         $table->integer('montagem_qtd')->nullable();
		//         $table->integer('entrega_qtd')->nullable();
		//         $table->integer('medicao_id')->nullable();
		//         $table->index('fk_medicoes_idx');
		//     });

		// Schema::create('pecamontagem', function(Blueprint $table) {
		//         $table->increments('id');
		//         $table->integer('lote_id')->nullable();
		//         $table->integer('obra_id')->nullable();
		//         $table->integer('etapa_id')->nullable();
		//         $table->integer('medicao_id')->nullable();
		//         $table->integer('peca_id')->nullable();
		//         $table->date('dataprev_montagem')->nullable();
		//         $table->date('datareal_montagem')->nullable();
		//         $table->date('dataprev_entrega')->nullable();
		//         $table->date('datareal_entrega')->nullable();
		//         $table->boolean('montagem')->nullable();
		//         $table->boolean('entrega')->nullable();
		//         $table->index('fklote');
		//         $table->index('obra_id');
		//         $table->index('etapa_id');
		//         $table->index('medicao_id');
		//         $table->index('peca_id');
		//     });

		Schema::create('cjtomontagem', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('lote_id')->nullable()->unsigned();
			$table->foreign('lote_id')->references('id')->on('lotes')->onDelete('set null');

			$table->integer('obra_id')->nullable()->unsigned();
			$table->foreign('obra_id')->references('id')->on('obras')->onDelete('set null');

			$table->integer('etapa_id')->nullable()->unsigned();
			$table->foreign('etapa_id')->references('id')->on('etapas')->onDelete('set null');

			$table->integer('medicao_id')->nullable()->unsigned();
			$table->foreign('medicao_id')->references('id')->on('medicoes')->onDelete('set null');

			$table->integer('handle_id')->nullable()->unsigned();
			$table->foreign('handle_id')->references('id')->on('handles')->onDelete('set null');

			$table->date('dataprev_montagem')->nullable();
			$table->date('datareal_montagem')->nullable();
			$table->date('dataprev_entrega')->nullable();
			$table->date('datareal_entrega')->nullable();

			$table->boolean('montagem')->nullable();
			$table->boolean('entrega')->nullable();

			$table->integer('version')->default(1)->nullable();

			$table->integer('user_id')->nullable()->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
			$table->integer('locatario_id')->unsigned();
			$table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

			$table->timestamps();
		});

		Schema::create('cjtofabr', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('lote_id')->nullable()->unsigned();
			$table->foreign('lote_id')->references('id')->on('lotes')->onDelete('set null');

			$table->integer('handle_id')->nullable()->unsigned();
			$table->foreign('handle_id')->references('id')->on('handles')->onDelete('set null');

			$table->integer('user_id')->nullable()->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
			$table->integer('locatario_id')->unsigned();
			$table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

			$table->timestamps();
		});

		Schema::create('cronos', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('estagio_id')->nullable()->unsigned();
			$table->foreign('estagio_id')->references('id')->on('estagios')->onDelete('cascade');

			$table->integer('cjtofab_id')->nullable()->unsigned();
			$table->foreign('cjtofab_id')->references('id')->on('cjtofabr')->onDelete('cascade');

			$table->date('data_prev')->nullable();
			$table->date('data_real')->nullable();

			$table->integer('version')->default(1)->nullable();

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('locatario_id')->unsigned();
			$table->foreign('locatario_id')->references('id')->on('locatarios')->onDelete('cascade');

			$table->timestamps();
		});

		// Schema::create('projeto', function(Blueprint $table) {
		//         $table->increments('id_PROJETO');
		//         $table->string('NOME', 255)->nullable();
		//         $table->dateTime('DATA')->nullable();
		//         $table->text('ARQ_2D')->nullable();
		//         $table->text('ARQ_3D')->nullable();
		//     });

		// Schema::create('tipoestagio', function(Blueprint $table) {
		//         $table->increments('id');
		//         $table->string('DESCRICAO', 255)->nullable();
		//     });

		// Schema::create('usuarios', function(Blueprint $table) {
		//         $table->increments('id');
		//         $table->integer('cliente_id')->nullable();
		//         $table->string('USUARIO', 64)->nullable();
		//         $table->string('SENHA', 12)->nullable();
		//         $table->integer('FKGRUPOTRABALHO')->nullable();
		//         $table->integer('FKESTAGIO')->nullable();
		//         $table->string('EMAIL', 64)->nullable();
		//         $table->boolean('Logavel')->nullable();
		//         $table->boolean('ReportProducao')->nullable();
		//         $table->integer('Acesso')->nullable();
		//         $table->string('obras_permitidas', 255)->nullable();
		//     });

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

		Schema::table('cronos', function (Blueprint $table) {
			$table->dropForeign('cronos_estagio_id_foreign');
			$table->dropForeign('cronos_cjtofab_id_foreign');
			$table->dropForeign('cronos_user_id_foreign');
			$table->dropForeign('cronos_locatario_id_foreign');
		});
		Schema::drop('cronos');

		Schema::table('cjtofabr', function (Blueprint $table) {
			$table->dropForeign('cjtofabr_lote_id_foreign');
			$table->dropForeign('cjtofabr_handle_id_foreign');
			$table->dropForeign('cjtofabr_user_id_foreign');
			$table->dropForeign('cjtofabr_locatario_id_foreign');
		});
		Schema::drop('cjtofabr');

		Schema::table('cjtomontagem', function (Blueprint $table) {
			$table->dropForeign('cjtomontagem_lote_id_foreign');
			$table->dropForeign('cjtomontagem_obra_id_foreign');
			$table->dropForeign('cjtomontagem_etapa_id_foreign');
			$table->dropForeign('cjtomontagem_medicao_id_foreign');
			$table->dropForeign('cjtomontagem_handle_id_foreign');
		});
		Schema::drop('cjtomontagem');

		Schema::table('temp_handles', function (Blueprint $table) {
			$table->dropForeign('temp_handles_obra_id_foreign');
			$table->dropForeign('temp_handles_lote_id_foreign');
			$table->dropForeign('temp_handles_estagio_id_foreign');
			$table->dropForeign('temp_handles_etapa_id_foreign');
			$table->dropForeign('temp_handles_importacao_id_foreign');
			$table->dropForeign('temp_handles_medicao_id_foreign');
			$table->dropForeign('temp_handles_user_id_foreign');
			$table->dropForeign('temp_handles_locatario_id_foreign');
		});
		Schema::drop('temp_handles');

		Schema::table('handles', function (Blueprint $table) {
			$table->dropForeign('handles_obra_id_foreign');
			$table->dropForeign('handles_lote_id_foreign');
			$table->dropForeign('handles_estagio_id_foreign');
			$table->dropForeign('handles_etapa_id_foreign');
			$table->dropForeign('handles_importacao_id_foreign');
			$table->dropForeign('handles_medicao_id_foreign');
			$table->dropForeign('handles_user_id_foreign');
			$table->dropForeign('handles_locatario_id_foreign');
		});
		Schema::drop('handles');

		Schema::table('importacoes', function (Blueprint $table) {
			$table->dropForeign('importacoes_cliente_id_foreign');
			$table->dropForeign('importacoes_obra_id_foreign');
			$table->dropForeign('importacoes_etapa_id_foreign');
			$table->dropForeign('importacoes_subetapa_id_foreign');
			$table->dropForeign('importacoes_user_id_foreign');
			$table->dropForeign('importacoes_locatario_id_foreign');
		});
		Schema::drop('importacoes');

		Schema::table('medicoes', function (Blueprint $table) {
			$table->dropForeign('medicoes_etapa_id_foreign');
			$table->dropForeign('medicoes_user_id_foreign');
			$table->dropForeign('medicoes_locatario_id_foreign');
		});
		Schema::drop('medicoes');

		Schema::table('lotes', function (Blueprint $table) {
			$table->dropForeign('lotes_obra_id_foreign');
			$table->dropForeign('lotes_etapa_id_foreign');
			$table->dropForeign('lotes_subetapa_id_foreign');
			$table->dropForeign('lotes_user_id_foreign');
			$table->dropForeign('lotes_locatario_id_foreign');
		});
		Schema::drop('lotes');

		Schema::table('estagios', function (Blueprint $table) {
			$table->dropForeign('estagios_tipoestagio_id_foreign');
			$table->dropForeign('estagios_user_id_foreign');
			$table->dropForeign('estagios_locatario_id_foreign');
		});
		Schema::drop('estagios');

		Schema::table('tiposestagios', function (Blueprint $table) {
			$table->dropForeign('tiposestagios_user_id_foreign');
			$table->dropForeign('tiposestagios_locatario_id_foreign');
		});
		Schema::drop('tiposestagios');

		Schema::table('subetapas', function (Blueprint $table) {
			$table->dropForeign('subetapas_tiposubetapa_id_foreign');
			$table->dropForeign('subetapas_etapa_id_foreign');
			$table->dropForeign('subetapas_user_id_foreign');
			$table->dropForeign('subetapas_locatario_id_foreign');
		});
		Schema::drop('subetapas');
		Schema::table('tipossubetapas', function (Blueprint $table) {
			$table->dropForeign('tipossubetapas_user_id_foreign');
			$table->dropForeign('tipossubetapas_locatario_id_foreign');
		});
		Schema::drop('tipossubetapas');

		Schema::table('etapas', function (Blueprint $table) {
			$table->dropForeign('etapas_obra_id_foreign');
			$table->dropForeign('etapas_user_id_foreign');
			$table->dropForeign('etapas_locatario_id_foreign');
		});
		Schema::drop('etapas');

		Schema::table('obras', function (Blueprint $table) {
			$table->dropForeign('obras_cliente_id_foreign');
			$table->dropForeign('obras_user_id_foreign');
			$table->dropForeign('obras_locatario_id_foreign');
		});
		Schema::drop('obras');

		Schema::table('logs', function (Blueprint $table) {
			$table->dropForeign('logs_user_id_foreign');
			$table->dropForeign('logs_locatario_id_foreign');
		});
		Schema::drop('logs');

		Schema::table('contatos', function (Blueprint $table) {
			$table->dropForeign('contatos_tipo_id_foreign');
			$table->dropForeign('contatos_user_id_foreign');
			$table->dropForeign('contatos_locatario_id_foreign');
		});
		Schema::drop('contatos');
		Schema::table('tiposcontatos', function (Blueprint $table) {
			$table->dropForeign('tiposcontatos_user_id_foreign');
			$table->dropForeign('tiposcontatos_locatario_id_foreign');
		});
		Schema::drop('tiposcontatos');

		Schema::table('clientes', function (Blueprint $table) {
			$table->dropForeign('clientes_user_id_foreign');
			$table->dropForeign('clientes_locatario_id_foreign');
		});
		Schema::drop('clientes');

		Schema::table('users', function (Blueprint $table) {
			$table->dropForeign('users_locatario_id_foreign');
		});

		Schema::drop('locatarios');
	}
}
