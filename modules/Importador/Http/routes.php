<?php

Route::group(['middleware' => 'web', 'prefix' => 'importador', 'namespace' => 'Modules\Importador\Http\Controllers'], function()
{
	Route::get('/', 'ImportadorController@index')->name('importador');
	Route::post('etapas', 'ImportadorController@getEtapas')->name('importador.etapas');
	Route::post('subetapas', 'ImportadorController@getSubetapas')->name('importador.subetapas');
	Route::post('importar', 'ImportadorController@toImport')->name('importador.importar');
});