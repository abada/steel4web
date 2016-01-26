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

/*
* OBRAS
*/

Route::get('obra/cadastro', array('middleware' => 'admin', 'as' => 'obra/cadastro', 'uses' => 'importer\ObrasController@cadastro'));
Route::get('obra/editar/{id}', array('middleware' => 'admin', 'as' => 'obra/editar/{id}', 'uses' => 'importer\ObrasController@editar'));
Route::post('obra/gravar', array('middleware' => 'admin', 'as' => 'obra/gravar', 'uses' => 'importer\ObrasController@gravar'));
Route::get('obras', array('middleware' => 'admin', 'as' => 'obras', 'uses' => 'importer\ObrasController@index'));
Route::get('obra/{id}', array('middleware' => 'admin', 'as' => 'obra', 'uses' => 'importer\ObrasController@ver'));

//END OBRAS

/*
* ETAPAS
*/

Route::get('etapa/cadastro/{obraID}', array('middleware' => 'admin', 'as' => 'etapa/cadastro/{obraID}', 'uses' => 'importer\EtapasController@cadastrar'));
Route::post('etapa/gravar', array('middleware' => 'admin', 'as' => 'etapa/gravar', 'uses' => 'importer\EtapasController@gravar'));
Route::get('etapa/editar/{id}', array('middleware' => 'admin', 'as' => 'etapa/editar/{id}', 'uses' => 'importer\EtapasController@editar'));
Route::post('etapa/update', array('middleware' => 'admin', 'as' => 'etapa/update', 'uses' => 'importer\EtapasController@gravarEdicao'));

//END ETAPAS

/*
* CLIENTES
*/
Route::get('cliente/cadastro', array('middleware' => 'admin', 'as' => 'cliente/cadastro', 'uses' => 'importer\ClientesController@cadastro'));
Route::get('clientes', array('middleware' => 'admin', 'as' => 'clientes', 'uses' => 'importer\ClientesController@index'));
Route::get('cliente/{id}', array('middleware' => 'admin', 'as' => 'cliente/{id}', 'uses' => 'importer\ClientesController@ver'));
Route::get('cliente/editar/{id}', array('middleware' => 'admin', 'as' => 'cliente/editar/{id}', 'uses' => 'importer\ClientesController@editar'));
Route::post('cliente/update', array('middleware' => 'admin', 'as' => 'cliente/update', 'uses' => 'importer\ClientesController@gravarEdicao'));

Route::post('cliente/gravar', array('middleware' => 'admin', 'as' => 'cliente/gravar', 'uses' => 'importer\ClientesController@gravar'));

//END CLIENTES

/*
* CONTATOS
*/

Route::get('tipo/cadastro', array('middleware' => 'admin', 'as' => 'tipo/cadastro', 'uses' => 'importer\ContatosController@tipoCadastro'));
Route::get('contato/cadastro', array('middleware' => 'admin', 'as' => 'contato/cadastro', 'uses' => 'importer\ContatosController@cadastro'));
Route::get('contatos', array('middleware' => 'admin', 'as' => 'contatos', 'uses' => 'importer\ContatosController@index'));
Route::get('contato/tipos', array('middleware' => 'admin', 'as' => 'contato/tipos', 'uses' => 'importer\ContatosController@tipos'));
Route::get('contato/{id}', array('middleware' => 'admin', 'as' => 'contato/{id}', 'uses' => 'importer\ContatosController@ver'));
Route::get('contato/editar/{id}', array('middleware' => 'admin', 'as' => 'contato/editar/{id}', 'uses' => 'importer\ContatosController@editar'));
Route::post('contato/update', array('middleware' => 'admin', 'as' => 'contato/update', 'uses' => 'importer\ContatosController@gravarEdicao'));
Route::post('contato/gravar', array('middleware' => 'admin', 'as' => 'contato/gravar', 'uses' => 'importer\ContatosController@gravar'));
Route::post('tipo/gravar', array('middleware' => 'admin', 'as' => 'tipo/gravar', 'uses' => 'importer\ContatosController@gravarTipo'));
Route::get('tipo/editar/{id}', array('middleware' => 'admin', 'as' => 'tipo/editar/{id}', 'uses' => 'importer\ContatosController@tipoEditar'));
Route::get('tipo/excluir/{id}', array('middleware' => 'admin', 'as' => 'tipo/excluir/{id}', 'uses' => 'importer\ContatosController@tipoExcluir'));
Route::post('tipo/update', array('middleware' => 'admin', 'as' => 'tipo/update', 'uses' => 'importer\ContatosController@gravarTipoEdicao'));

//END CONTATOS

/*
* END IMPORTER
*/