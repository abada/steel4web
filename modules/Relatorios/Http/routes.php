<?php

Route::group(['middleware' => 'admin', 'prefix' => 'relatorios', 'namespace' => 'Modules\Relatorios\Http\Controllers'], function()
{
	Route::get('/', 'RelatoriosController@index');
	Route::get('obras', 'RelatoriosController@obras');
	Route::get('lotes', 'RelatoriosController@lotes');
	Route::get('teste', 'RelatoriosController@teste');
	Route::get('getConjuntos/{params}', 'RelatoriosController@getConjuntos')->name('relatorios/getConjuntos');
	Route::get('lote/{params}', 'RelatoriosController@getPdfLote')->name('relatorios/lote');
	Route::get('getEstagios/{params}', 'RelatoriosController@getEstagios')->name('relatorios/getEstagios');
});