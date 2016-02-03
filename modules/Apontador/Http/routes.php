<?php

Route::group(['middleware' => 'admin', 'prefix' => 'apontador', 'namespace' => 'Modules\Apontador\Http\Controllers'], function()
{
	Route::get('/', 'ApontadorController@index')->name('apontador');
	Route::post('setHistory', 'ApontadorController@setHistory')->name('setHistory');;
});