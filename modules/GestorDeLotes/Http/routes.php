<?php

Route::group(['middleware' => 'web', 'prefix' => 'gestordelotes', 'namespace' => 'Modules\GestorDeLotes\Http\Controllers'], function()
{
	Route::get('/', 'GestorDeLotesController@index');
});