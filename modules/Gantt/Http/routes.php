<?php

Route::group(['middleware' => 'web', 'prefix' => 'gantt', 'namespace' => 'Modules\Gantt\Http\Controllers'], function()
{
	Route::get('/', 'GanttController@index');
	Route::get('/planejamento', 'GanttController@planejamento');
	Route::get('/fabricacao', 'GanttController@fabricacao');
});