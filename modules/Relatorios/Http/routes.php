<?php

Route::group(['middleware' => 'web', 'prefix' => 'relatorios', 'namespace' => 'Modules\Relatorios\Http\Controllers'], function()
{
	Route::get('/', 'RelatoriosController@index');
	Route::get('obras', 'RelatoriosController@obras');
	Route::get('teste', 'RelatoriosController@teste');
	Route::get('getConjuntosObra/{id}', 'RelatoriosController@getConjuntosObra')->name('relatorios/getConjuntosObra');
});