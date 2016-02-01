<?php

Route::group(['middleware' => 'admin', 'prefix' => 'api', 'namespace' => 'Modules\Api\Http\Controllers'], function () {
	// Route::get('/', 'ApiController@index');
	Route::get('/', function () {
		return json_encode(['error' => 'Ei! O que está fazendo???']);
	});

	Route::get('/{resource_name?}/{resource_id?}/attach/{attached_resource_name?}/{attached_resource_id?}', 'ApiController@attach');
	Route::get('/{resource_name?}/{resource_id?}/{resource_relationship?}/{related_resource_id?}/{related_related_resource?}/{related_related_resource_id?}', 'ApiController@index');
	Route::post('/{resource_name?}/{resource_id?}/{resource_relationship?}/{related_resource_id?}/{related_related_resource?}/{related_related_resource_id?}', 'ApiController@store');
});