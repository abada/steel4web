<?php

Route::group(['middleware' => 'web'], function () {
	/**
	 * Switch between the included languages
	 */
//	Route::group(['namespace' => 'Language'], function () {
//		require (__DIR__ . '/Routes/Language/Language.php');
//	});

	/**
	 * Frontend Routes
	 * Namespaces indicate folder structure
	 */
	Route::group(['namespace' => 'Frontend'], function () {
		require (__DIR__ . '/Routes/Frontend/Frontend.php');
		require (__DIR__ . '/Routes/Frontend/Access.php');
	});
});

/**
 * Backend Routes
 * Namespaces indicate folder structure
 * Admin middleware groups web, auth, and routeNeedsPermission
 */
 Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'middleware' => 'admin'], function () {
	/**
	 * These routes need view-backend permission
	 * (good if you want to allow more than one group in the backend,
	 * then limit the backend features by different roles or permissions)
	 *
	 * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
	 */
	require (__DIR__ . '/Routes/Backend/Dashboard.php');
	require (__DIR__ . '/Routes/Backend/Access.php');
	require (__DIR__ . '/Routes/Backend/LogViewer.php');
});

/**
 *Cadastros Routes.
 *Developer: Me(Vini)
 *Prefixes: obra(s), cliente(s), contato(s), usuario(s), etapa(s), subetapa(s).
 */
/* DASHBOARD */
Route::get('/', array('middleware' => 'admin', 'as' => '/', 'uses' => 'Cadastros\DashboardController@index'));

/*
 * OBRAS
 */

/**
 * The application's global HTTP middleware stack.
 *
 * These middleware are run during every request to your application.
 *
 * The Midleware asigned to each routes are groups defined in the app/http/kernel, which include the permissions for the route.
 */

//Pagina de Cadastro
Route::get('obra/cadastro', array('middleware' => 'criar-cadastro', 'as' => 'obra/cadastro', 'uses' => 'Cadastros\ObrasController@cadastro'));
//Pagina de Edicao
Route::get('obra/editar/{id}', array('middleware' => 'editar-cadastro', 'as' => 'obra/editar/{id}', 'uses' => 'Cadastros\ObrasController@editar'));
//Realiza Cadastro
Route::post('obra/gravar', array('middleware' => 'criar-cadastro', 'as' => 'obra/gravar', 'uses' => 'Cadastros\ObrasController@gravar'));
//Realiza Edicao
Route::post('obra/update', array('middleware' => 'editar-cadastro', 'as' => 'obra/update', 'uses' => 'Cadastros\ObrasController@update'));
//Lista Obras
Route::get('obras', array('middleware' => 'ver-cadastro', 'as' => 'obras', 'uses' => 'Cadastros\ObrasController@index'));
//Perfil da Obra
Route::get('obra/{id}', array('middleware' => 'ver-cadastro', 'as' => 'obra', 'uses' => 'Cadastros\ObrasController@ver'));
//Mudar Status
Route::get('obra/status/{id}', array('middleware' => 'editar-cadastro', 'as' => 'obra/status', 'uses' => 'Cadastros\ObrasController@editarStatus'));
//Excluir Obra
Route::get('obra/excluir/{id}', array('middleware' => 'deletar-cadastro', 'as' => 'obra/excluir', 'uses' => 'Cadastros\ObrasController@excluir'));

//END OBRAS

/*
 * ETAPAS
 */
//Pagina de Cadastro
Route::get('etapa/cadastro/{obraID}', array('middleware' => 'criar-cadastro', 'as' => 'etapa/cadastro/{obraID}', 'uses' => 'Cadastros\EtapasController@cadastrar'));
//Realiza Cadastro
Route::post('etapa/gravar', array('middleware' => 'criar-cadastro', 'as' => 'etapa/gravar', 'uses' => 'Cadastros\EtapasController@gravar'));
//Pagina de Edicao
Route::get('etapa/editar/{id}', array('middleware' => 'editar-cadastro', 'as' => 'etapa/editar/{id}', 'uses' => 'Cadastros\EtapasController@editar'));
//Realiza Edicao
Route::post('etapa/update', array('middleware' => 'editar-cadastro', 'as' => 'etapa/update', 'uses' => 'Cadastros\EtapasController@gravarEdicao'));
//Exclui Etapa
Route::post('etapa/excluir', array('middleware' => 'deletar-cadastro', 'as' => 'etapa/excluir', 'uses' => 'Cadastros\EtapasController@excluir'));

//END ETAPAS

/*
 *  SUBETAPAS
 */
//Pagina de Cadastro
Route::get('subetapa/criar/{id}', array('middleware' => 'criar-cadastro', 'as' => 'subetapa/criar/{id}', 'uses' => 'Cadastros\SubetapasController@cadastrar'));
//Realiza Cadastro
Route::post('subetapa/gravar', array('middleware' => 'criar-cadastro', 'as' => 'subetapa/gravar', 'uses' => 'Cadastros\SubetapasController@gravar'));
//Pagina de Edicao
Route::get('subetapa/editar/{id}', array('middleware' => 'editar-cadastro', 'as' => 'subetapa/editar/{id}', 'uses' => 'Cadastros\SubetapasController@editar'));
//Realiza Edicao
Route::post('subetapa/update', array('middleware' => 'editar-cadastro', 'as' => 'subetapa/update', 'uses' => 'Cadastros\SubetapasController@gravarEdicao'));
//Exclui Etapa
Route::post('subetapa/excluir', array('middleware' => 'deletar-cadastro', 'as' => 'subetapa/excluir', 'uses' => 'Cadastros\SubetapasController@excluir'));
//Lista Tipos de Subetapas
Route::get('subetapa/tipos', array('middleware' => 'ver-cadastro', 'as' => 'subetapa/tipos', 'uses' => 'Cadastros\SubetapasController@tipos'));
//Gravar Tipos de Subetapas
Route::post('subetapa/tipo/gravar', array('middleware' => 'criar-cadastro', 'as' => 'subetapa/tipo/gravar', 'uses' => 'Cadastros\SubetapasController@gravarTipo'));
//Pagina de Edicao de Tipo de Subetapas
Route::get('subetapa/tipo/editar/{id}', array('middleware' => 'editar-cadastro', 'as' => 'subetapa/tipo/editar/{id}', 'uses' => 'Cadastros\SubetapasController@tipoEditar'));
//Excluir Tipo de Subetapas
Route::get('subetapa/tipo/excluir/{id}', array('middleware' => 'deletar-cadastro', 'as' => 'subetapa/tipo/excluir/{id}', 'uses' => 'Cadastros\SubetapasController@tipoExcluir'));
//Realiza Edicao de Tipo de Subetapas
Route::post('subetapa/tipo/update', array('middleware' => 'editar-cadastro', 'as' => 'subetapa/tipo/update', 'uses' => 'Cadastros\SubetapasController@gravarTipoEdicao'));
//Pagina de Cadastro de Tipo de Subetapas
Route::get('subetapa/tipo/cadastro', array('middleware' => 'criar-cadastro', 'as' => 'subetapa/tipo/cadastro', 'uses' => 'Cadastros\SubetapasController@tipoCadastro'));

//END SUBETAPAS

/*
 * CLIENTES
 */
//Pagina de Cadastro
Route::get('cliente/cadastro', array('middleware' => 'criar-cadastro', 'as' => 'cliente/cadastro', 'uses' => 'Cadastros\ClientesController@cadastro'));
//Lista Clientes
Route::get('clientes', array('middleware' => 'ver-cadastro', 'as' => 'clientes', 'uses' => 'Cadastros\ClientesController@index'));
//Perfil de Cliente
Route::get('cliente/{id}', array('middleware' => 'ver-cadastro', 'as' => 'cliente/{id}', 'uses' => 'Cadastros\ClientesController@ver'));
//Pagina de Edicao
Route::get('cliente/editar/{id}', array('middleware' => 'editar-cadastro', 'as' => 'cliente/editar/{id}', 'uses' => 'Cadastros\ClientesController@editar'));
//Realiza Edicao
Route::post('cliente/update', array('middleware' => 'editar-cadastro', 'as' => 'cliente/update', 'uses' => 'Cadastros\ClientesController@gravarEdicao'));
//Realiza Cadastro
Route::post('cliente/gravar', array('middleware' => 'criar-cadastro', 'as' => 'cliente/gravar', 'uses' => 'Cadastros\ClientesController@gravar'));
//Excluir Cliente
Route::get('cliente/excluir/{id}', array('middleware' => 'deletar-cadastro', 'as' => 'cliente/excluir', 'uses' => 'Cadastros\ClientesController@excluir'));

//END CLIENTES

/*
 * CONTATOS
 */
//Pagina de Cadastro de Tipo de Contatos
Route::get('contato/tipo/cadastro', array('middleware' => 'criar-cadastro', 'as' => 'contato/tipo/cadastro', 'uses' => 'Cadastros\ContatosController@tipoCadastro'));
//Pagina de Cadastro de Contatos
Route::get('contato/cadastro', array('middleware' => 'criar-cadastro', 'as' => 'contato/cadastro', 'uses' => 'Cadastros\ContatosController@cadastro'));
//Lista Contatos
Route::get('contatos', array('middleware' => 'ver-cadastro', 'as' => 'contatos', 'uses' => 'Cadastros\ContatosController@index'));
//Lista Tipos de Contatos
Route::get('contato/tipos', array('middleware' => 'ver-cadastro', 'as' => 'contato/tipos', 'uses' => 'Cadastros\ContatosController@tipos'));
//Perfil do Contato
Route::get('contato/{id}', array('middleware' => 'ver-cadastro', 'as' => 'contato/{id}', 'uses' => 'Cadastros\ContatosController@ver'));
//Pagina de Edicao de CLientes
Route::get('contato/editar/{id}', array('middleware' => 'editar-cadastro', 'as' => 'contato/editar/{id}', 'uses' => 'Cadastros\ContatosController@editar'));
//Realiza Edicao de Contatos
Route::post('contato/update', array('middleware' => 'editar-cadastro', 'as' => 'contato/update', 'uses' => 'Cadastros\ContatosController@gravarEdicao'));
//Realiza Cadastro de Contatos
Route::post('contato/gravar', array('middleware' => 'criar-cadastro', 'as' => 'contato/gravar', 'uses' => 'Cadastros\ContatosController@gravar'));
//Realiza Cadastro de Tipo de Contatos
Route::post('contato/tipo/gravar', array('middleware' => 'criar-cadastro', 'as' => 'contato/tipo/gravar', 'uses' => 'Cadastros\ContatosController@gravarTipo'));
//Pagina de Edicao de Tipo de Clientes
Route::get('contato/tipo/editar/{id}', array('middleware' => 'editar-cadastro', 'as' => 'contato/tipo/editar/{id}', 'uses' => 'Cadastros\ContatosController@tipoEditar'));
//Excluir Tipo de Contato
Route::get('contato/tipo/excluir/{id}', array('middleware' => 'deletar-cadastro', 'as' => 'contato/tipo/excluir/{id}', 'uses' => 'Cadastros\ContatosController@tipoExcluir'));
//Realiza Edicao de Tipo de Contatos
Route::post('contato/tipo/update', array('middleware' => 'editar-cadastro', 'as' => 'contato/tipo/update', 'uses' => 'Cadastros\ContatosController@gravarTipoEdicao'));
//Excluir Contatos
Route::get('contato/excluir/{id}', array('middleware' => 'deletar-cadastro', 'as' => 'contato/excluir', 'uses' => 'Cadastros\ContatosController@excluir'));

//END CONTATOS

/*
 * END Cadastros
 */




// GERAR SENHA CRIPTOGRAFADA
Route::get('gerarsenha', function () {
	return '<form method="POST">
                <input type="text" name="senha" placeholder="Digite a senha">
                <button type="submit">Enviar</button>
            </form>';
});
Route::post('gerarsenha', function () {
	return bcrypt($_POST['senha']);
});