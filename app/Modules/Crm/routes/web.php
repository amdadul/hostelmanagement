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

});
