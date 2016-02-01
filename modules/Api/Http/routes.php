<?php

Route::group(['middleware' => 'admin', 'prefix' => 'api', 'namespace' => 'Modules\Api\Http\Controllers'], function () {
	// Route::get('/', 'ApiController@index');
	Route::get('/', function () {
		return json_encode(['error' => 'Ei! O que está fazendo???']);
	});

	Route::get('/{resource_name?}/{resource_id?}/attach/{attached_resource_name?}/{attached_resource_id?}', 'ApiController@attach');
	Route::get('/{res_name?}/{res_id?}/{rel_one?}/{rel_one_id?}/{rel_two?}/{rel_two_id?}/{rel_three?}/{rel_three_id?}/{rel_four?}/{rel_four_id?}', 'ApiController@index');
	Route::post('/{res_name?}/{res_id?}/{rel_one?}/{rel_one_id?}/{rel_two?}/{rel_two_id?}/{rel_three?}/{rel_three_id?}/{rel_four?}/{rel_four_id?}', 'ApiController@store');
});