<?php

Route::group(['middleware' => 'web', 'prefix' => 'relatorios', 'namespace' => 'Modules\Relatorios\Http\Controllers'], function()
{
	Route::get('/', 'RelatoriosController@index')->name('relatorios');
	Route::get('obras', 'RelatoriosController@obras')->name('relatorios/obras');
	Route::get('lotes', 'RelatoriosController@lotes')->name('relatorios/teste');
	Route::get('teste', 'RelatoriosController@teste');
	Route::get('getConjuntos/{params}', 'RelatoriosController@getConjuntos')->name('relatorios/getConjuntos');
});