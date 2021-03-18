<?php

Route::group(['middleware' => ['auth:web']], function () {

    Route::get('config', 'ConfigController@welcome');

    Route::group(['prefix' => 'admin/config/lookups'], function () {
        Route::get('/', 'LookupController@index')->name('config.lookups.index');
        Route::get('/create', 'LookupController@create')->name('config.lookups.create');
        Route::post('/store', 'LookupController@store')->name('config.lookups.store');
        Route::get('/{id}/edit', 'LookupController@edit')->name('config.lookups.edit');
        Route::post('/{id}/update', 'LookupController@update')->name('config.lookups.update');
        Route::delete('/{id}/delete', 'LookupController@delete')->name('config.lookups.delete');
    });

    Route::group(['prefix' => 'admin/config/settings'], function () {
        Route::get('/', 'SettingController@index')->name('config.settings.index');
        Route::get('/create', 'SettingController@create')->name('config.settings.create');
        Route::post('/store', 'SettingController@store')->name('config.settings.store');
        Route::get('/{id}/edit', 'SettingController@edit')->name('config.settings.edit');
        Route::post('/{id}/update', 'SettingController@update')->name('config.settings.update');
        Route::delete('/{id}/delete', 'SettingController@delete')->name('config.settings.delete');
    });

});
