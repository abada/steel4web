<?php

Route::group(['middleware' => 'importador', 'prefix' => 'importador', 'namespace' => 'Modules\Importador\Http\Controllers'], function()
{
	Route::get('/', 'ImportadorController@index')->name('importador');
	Route::get('download/{file}', 'ImportadorController@download')->name('importador.download');
	Route::post('etapas', 'ImportadorController@getEtapas')->name('importador.etapas');
	Route::post('subetapas', 'ImportadorController@getSubetapas')->name('importador.subetapas');
	Route::post('importar', 'ImportadorController@toImport')->name('importador.importar');
	Route::post('gravar', 'ImportadorController@gravar')->name('importador.gravar');
	
	Route::post('excluir', 'ImportadorController@excluir')->name('importador.excluir');
});
