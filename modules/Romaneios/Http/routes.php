<?php

Route::group(['middleware' => 'web', 'prefix' => 'romaneios', 'namespace' => 'Modules\Romaneios\Http\Controllers'], function()
{
	Route::get('/', 'RomaneiosController@index')->name('romaneios');

	Route::get('criar', 'RomaneiosController@criar')->name('romaneios/criar');
	Route::post('setRHistory', 'RomaneiosController@setHistory')->name('setRHistory');
	Route::get('getConjuntos/{params}', 'RomaneiosController@getConjuntos')->name('romaneios/getConjuntos');
	Route::post('gravar', 'RomaneiosController@gravar')->name('romaneios/gravar');
	Route::post('adicionar', 'RomaneiosController@adicionar')->name('romaneios/adicionar');
	Route::post('remover', 'RomaneiosController@remover')->name('romaneios/remover');
	Route::get('perfil/{id}', 'RomaneiosController@perfil')->name('romaneios/perfil');
	Route::get('getConjuntosRomaneio/{id}', 'RomaneiosController@getConjuntosRomaneio')->name('romaneios/getConjuntosRomaneio');
});