<?php

/**
 * Frontend Controllers
 */
//Route::get('/', 'FrontendController@index')->name('frontend.index');
//Route::get('macros', 'FrontendController@macros')->name('frontend.macros');

/**
 * These frontend controllers require the user to be logged in
 */
Route::group(['middleware' => 'admin'], function () {
    Route::group(['namespace' => 'User'], function() {
    	Route::get('files/{file}/preview', ['as' => 'file_preview', 'uses' => 'ProfileController@preview']);
        Route::get('perfil', 'DashboardController@index')->name('frontend.user.perfil');
        Route::get('perfil/editar', 'ProfileController@edit')->name('frontend.user.perfil.editar');
        Route::patch('profile/update', 'ProfileController@update')->name('frontend.user.profile.update');
    });
});