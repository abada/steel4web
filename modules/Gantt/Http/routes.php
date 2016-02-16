<?php

Route::group(['middleware' => 'web', 'prefix' => 'gantt', 'namespace' => 'Modules\Gantt\Http\Controllers'], function()
{
	Route::get('/', 'GanttController@index');
});