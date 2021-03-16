<?php

Route::group(['middleware' => ['auth:web']], function () {

    Route::get('crm', 'CrmController@welcome');

    Route::group(['prefix' => 'admin/crm/buildings'], function () {
        Route::get('/', 'BuildingController@index')->name('crm.buildings.index');
        Route::get('/create', 'BuildingController@create')->name('crm.buildings.create');
        Route::post('/store', 'BuildingController@store')->name('crm.buildings.store');
        Route::get('/{id}/edit', 'BuildingController@edit')->name('crm.buildings.edit');
        Route::post('/{id}/update', 'BuildingController@update')->name('crm.buildings.update');
        Route::delete('/{id}/delete', 'BuildingController@delete')->name('crm.buildings.delete');
    });

    Route::group(['prefix' => 'admin/crm/floors'], function () {
        Route::get('/', 'FloorController@index')->name('crm.floors.index');
        Route::get('/create', 'FloorController@create')->name('crm.floors.create');
        Route::post('/store', 'FloorController@store')->name('crm.floors.store');
        Route::get('/{id}/edit', 'FloorController@edit')->name('crm.floors.edit');
        Route::post('/{id}/update', 'FloorController@update')->name('crm.floors.update');
        Route::delete('/{id}/delete', 'FloorController@delete')->name('crm.floors.delete');
    });

});
