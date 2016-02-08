<?php

Route::group(['middleware' => 'apontador', 'prefix' => 'apontador', 'namespace' => 'Modules\Apontador\Http\Controllers'], function()
{
	Route::get('/', 'ApontadorController@index')->name('apontador');
	Route::post('setHistory', 'ApontadorController@setHistory')->name('setHistory');
	Route::post('apontar', 'ApontadorController@apontar')->name('apontar');
});