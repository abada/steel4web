<?php

Route::group(['middleware' => 'admin', 'prefix' => 'gestordelotes', 'namespace' => 'Modules\GestorDeLotes\Http\Controllers'], function () {

	Route::get('/', 'GestorDeLotesController@index');

	Route::get('/lotes', 'GestorDeLotesController@lotes');
	Route::get('/handles', 'HandlesController@index');

	Route::resource('/lotes/pecas', 'PecasController');

	Route::resource('/obras', 'ObrasController');
	Route::resource('/obras/{obra_id}/etapas', 'EtapasController');
	Route::resource('/obras/{obra_id}/etapas/{etapa_id}/handles', 'HandlesController');
	Route::resource('/obras/{obra_id}/etapas/{etapa_id}/pecas', 'PecasController');
	Route::resource('/obras/{obra_id}/etapas/{etapa_id}/lotes', 'LotesController');

});