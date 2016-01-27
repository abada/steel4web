<?php

Route::group(['middleware' => 'web'], function() {
    /**
     * Switch between the included languages
     */
    Route::group(['namespace' => 'Language'], function () {
        require (__DIR__ . '/Routes/Language/Language.php');
    });

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
 *Importer Routes.
 *Developer: Me(Vini)
 *Note: i screwed the roles/permission dashboard, their url is ..../admin/access/users
 *Note2:i`m gonna need the routes prefixes: obra(s), cliente(s), contato(s), usuario(s), importacao(oes), apontador, tipo.
 */
/* DASHBOARD */
Route::get('dashboard', array('middleware' => 'admin', 'as' => 'dashboard', 'uses' => 'importer\DashboardController@index'));
/*
* OBRAS
*/
//Pagina de Cadastro
Route::get('obra/cadastro', array('middleware' => 'admin', 'as' => 'obra/cadastro', 'uses' => 'importer\ObrasController@cadastro'));
//Pagina de Edicao
Route::get('obra/editar/{id}', array('middleware' => 'admin', 'as' => 'obra/editar/{id}', 'uses' => 'importer\ObrasController@editar'));
//Realiza Cadastro
Route::post('obra/gravar', array('middleware' => 'admin', 'as' => 'obra/gravar', 'uses' => 'importer\ObrasController@gravar'));
//Realiza Edicao
Route::post('obra/update', array('middleware' => 'admin', 'as' => 'obra/update', 'uses' => 'importer\ObrasController@update'));
//Lista Obras
Route::get('obras', array('middleware' => 'admin', 'as' => 'obras', 'uses' => 'importer\ObrasController@index'));
//Perfil da Obra
Route::get('obra/{id}', array('middleware' => 'admin', 'as' => 'obra', 'uses' => 'importer\ObrasController@ver'));

//END OBRAS

/*
* ETAPAS
*/
//Pagina de Cadastro
Route::get('etapa/cadastro/{obraID}', array('middleware' => 'admin', 'as' => 'etapa/cadastro/{obraID}', 'uses' => 'importer\EtapasController@cadastrar'));
//Realiza Cadastro
Route::post('etapa/gravar', array('middleware' => 'admin', 'as' => 'etapa/gravar', 'uses' => 'importer\EtapasController@gravar'));
//Pagina de Edicao
Route::get('etapa/editar/{id}', array('middleware' => 'admin', 'as' => 'etapa/editar/{id}', 'uses' => 'importer\EtapasController@editar'));
//Realiza Edicao
Route::post('etapa/update', array('middleware' => 'admin', 'as' => 'etapa/update', 'uses' => 'importer\EtapasController@gravarEdicao'));
//Exclui Etapa
Route::post('etapa/excluir', array('middleware' => 'admin', 'as' => 'etapa/excluir', 'uses' => 'importer\EtapasController@excluir'));

//END ETAPAS

/*
* SUBETAPAS
*/
//Pagina de Cadastro
Route::get('subetapa/criar/{id}', array('middleware' => 'admin', 'as' => 'subetapa/criar/{id}', 'uses' => 'importer\SubetapasController@cadastrar'));
//Realiza Cadastro
Route::post('subetapa/gravar', array('middleware' => 'admin', 'as' => 'subetapa/gravar', 'uses' => 'importer\SubetapasController@gravar'));
//Pagina de Edicao
Route::get('subetapa/editar/{id}', array('middleware' => 'admin', 'as' => 'subetapa/editar/{id}', 'uses' => 'importer\SubetapasController@editar'));
//Realiza Edicao
Route::post('subetapa/update', array('middleware' => 'admin', 'as' => 'subetapa/update', 'uses' => 'importer\SubetapasController@gravarEdicao'));
//Exclui Etapa
Route::post('subetapa/excluir', array('middleware' => 'admin', 'as' => 'subetapa/excluir', 'uses' => 'importer\SubetapasController@excluir'));

//END SUBETAPAS

/*
* CLIENTES
*/
//Pagina de Cadastro
Route::get('cliente/cadastro', array('middleware' => 'admin', 'as' => 'cliente/cadastro', 'uses' => 'importer\ClientesController@cadastro'));
//Lista Clientes
Route::get('clientes', array('middleware' => 'admin', 'as' => 'clientes', 'uses' => 'importer\ClientesController@index'));
//Perfil de Cliente
Route::get('cliente/{id}', array('middleware' => 'admin', 'as' => 'cliente/{id}', 'uses' => 'importer\ClientesController@ver'));
//Pagina de Edicao
Route::get('cliente/editar/{id}', array('middleware' => 'admin', 'as' => 'cliente/editar/{id}', 'uses' => 'importer\ClientesController@editar'));
//Realiza Edicao
Route::post('cliente/update', array('middleware' => 'admin', 'as' => 'cliente/update', 'uses' => 'importer\ClientesController@gravarEdicao'));
//Realiza Cadastro
Route::post('cliente/gravar', array('middleware' => 'admin', 'as' => 'cliente/gravar', 'uses' => 'importer\ClientesController@gravar'));

//END CLIENTES

/*
* CONTATOS
*/
//Pagina de Cadastro de Tipo de Cliente
Route::get('tipo/cadastro', array('middleware' => 'admin', 'as' => 'tipo/cadastro', 'uses' => 'importer\ContatosController@tipoCadastro'));
//Pagina de Cadastro de Cliente
Route::get('contato/cadastro', array('middleware' => 'admin', 'as' => 'contato/cadastro', 'uses' => 'importer\ContatosController@cadastro'));
//Lista Contatos
Route::get('contatos', array('middleware' => 'admin', 'as' => 'contatos', 'uses' => 'importer\ContatosController@index'));
//Lista Tipos de Contatos
Route::get('contato/tipos', array('middleware' => 'admin', 'as' => 'contato/tipos', 'uses' => 'importer\ContatosController@tipos'));
//Perfil do Contato
Route::get('contato/{id}', array('middleware' => 'admin', 'as' => 'contato/{id}', 'uses' => 'importer\ContatosController@ver'));
//Pagina de Edicao de CLientes
Route::get('contato/editar/{id}', array('middleware' => 'admin', 'as' => 'contato/editar/{id}', 'uses' => 'importer\ContatosController@editar'));
//Realiza Edicao de Cliente
Route::post('contato/update', array('middleware' => 'admin', 'as' => 'contato/update', 'uses' => 'importer\ContatosController@gravarEdicao'));
//Realiza Cadastro de Cliente
Route::post('contato/gravar', array('middleware' => 'admin', 'as' => 'contato/gravar', 'uses' => 'importer\ContatosController@gravar'));
//Realiza Cadastro de Tipo de Cliente
Route::post('tipo/gravar', array('middleware' => 'admin', 'as' => 'tipo/gravar', 'uses' => 'importer\ContatosController@gravarTipo'));
//Pagina de Edicao de Tipo de Clientes
Route::get('tipo/editar/{id}', array('middleware' => 'admin', 'as' => 'tipo/editar/{id}', 'uses' => 'importer\ContatosController@tipoEditar'));
//Excluir Tipo de Contato
Route::get('tipo/excluir/{id}', array('middleware' => 'admin', 'as' => 'tipo/excluir/{id}', 'uses' => 'importer\ContatosController@tipoExcluir'));
//Realiza Edicao de Tipo de Cliente
Route::post('tipo/update', array('middleware' => 'admin', 'as' => 'tipo/update', 'uses' => 'importer\ContatosController@gravarTipoEdicao'));

//END CONTATOS

/*
* END IMPORTER
*/