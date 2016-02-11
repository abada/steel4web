<?php

Route::group(['middleware' => 'admin', 'prefix' => 'gestordelotes', 'namespace' => 'Modules\GestorDeLotes\Http\Controllers'], function () {

	Route::get('/', 'GestorDeLotesController@index');
	Route::get('/associaraolote/{id}', 'GestorDeLotesController@associaraolote');

	Route::get('/criar', 'GestorDeLotesController@create');
	Route::post('/', 'GestorDeLotesController@store');
	Route::get('/handles', 'HandlesController@index');

	Route::get('/producao/handles', 'ProducaoController@getHandles');
	Route::resource('/producao', 'ProducaoController');

	Route::resource('/pecas', 'PecasController');
	Route::get('/lotes/handles', 'LotesController@getHandles');
	Route::get('/lotes/remover', 'LotesController@removerconjuntos');
	Route::get('/lotes/removerlote', 'LotesController@removerlote');
	Route::get('/lotes/{id}/associar', 'LotesController@associar');
	Route::resource('/lotes', 'LotesController');

	Route::resource('/obras', 'ObrasController');
	Route::resource('/obras/{obra_id}/etapas', 'EtapasController');
	Route::resource('/obras/{obra_id}/etapas/{etapa_id}/handles', 'HandlesController');
	Route::resource('/obras/{obra_id}/etapas/{etapa_id}/pecas', 'PecasController');
	Route::resource('/obras/{obra_id}/etapas/{etapa_id}/lotes', 'LotesController');

});