<?php

Route::group(['middleware' => 'web', 'prefix' => 'romaneios', 'namespace' => 'Modules\Romaneios\Http\Controllers'], function()
{
	Route::get('/', 'RomaneiosController@index')->name('romaneios');
	Route::post('setRHistory', 'RomaneiosController@setHistory')->name('setRHistory');
});