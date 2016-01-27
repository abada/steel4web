<?php

Route::group(['middleware' => 'web', 'prefix' => 'importador', 'namespace' => 'Modules\Importador\Http\Controllers'], function()
{
	Route::get('/', 'ImportadorController@index');
});