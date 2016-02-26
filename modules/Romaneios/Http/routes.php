<?php

Route::group(['middleware' => 'web', 'prefix' => 'romaneios', 'namespace' => 'Modules\Romaneios\Http\Controllers'], function()
{
	Route::get('/', 'RomaneiosController@index')->name('romaneios');

	Route::get('criar', 'RomaneiosController@criar')->name('romaneios/criar');
	Route::get('pdf/{id}', 'RomaneiosController@pdf')->name('romaneios/pdf');
	Route::post('setRHistory', 'RomaneiosController@setHistory')->name('setRHistory');
	Route::get('getConjuntos/{params}', 'RomaneiosController@getConjuntos')->name('romaneios/getConjuntos');
	Route::get('fechar/{id}', 'RomaneiosController@fechar')->name('romaneios/fechar');
	Route::post('gravar', 'RomaneiosController@gravar')->name('romaneios/gravar');
	Route::post('update', 'RomaneiosController@update')->name('romaneios/update');
	Route::post('adicionar', 'RomaneiosController@adicionar')->name('romaneios/adicionar');
	Route::post('remover', 'RomaneiosController@remover')->name('romaneios/remover');
	Route::get('perfil/{id}', 'RomaneiosController@perfil')->name('romaneios/perfil');
	Route::get('excluir/{id}', 'RomaneiosController@excluir')->name('romaneios/excluir');
	Route::get('getPeso/{id}', 'RomaneiosController@getPeso')->name('romaneios/getPeso');
	Route::get('getConjuntosRomaneio/{id}', 'RomaneiosController@getConjuntosRomaneio')->name('romaneios/getConjuntosRomaneio');
});