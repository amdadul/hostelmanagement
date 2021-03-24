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
        Route::post('/get-floor', 'FloorController@getFloorByBuilding')->name('crm.floors.get-floor');
        Route::delete('/{id}/delete', 'FloorController@delete')->name('crm.floors.delete');
    });

    Route::group(['prefix' => 'admin/crm/flats'], function () {
        Route::get('/', 'FlatController@index')->name('crm.flats.index');
        Route::get('/create', 'FlatController@create')->name('crm.flats.create');
        Route::post('/store', 'FlatController@store')->name('crm.flats.store');
        Route::get('/{id}/edit', 'FlatController@edit')->name('crm.flats.edit');
        Route::post('/{id}/update', 'FlatController@update')->name('crm.flats.update');
        Route::post('/get-flat', 'FlatController@getFlatByFloor')->name('crm.flats.get-flat');
        Route::delete('/{id}/delete', 'FlatController@delete')->name('crm.flats.delete');
    });

    Route::group(['prefix' => 'admin/crm/rooms'], function () {
        Route::get('/', 'RoomController@index')->name('crm.rooms.index');
        Route::get('/create', 'RoomController@create')->name('crm.rooms.create');
        Route::post('/store', 'RoomController@store')->name('crm.rooms.store');
        Route::get('/{id}/edit', 'RoomController@edit')->name('crm.rooms.edit');
        Route::post('/{id}/update', 'RoomController@update')->name('crm.rooms.update');
        Route::post('/get-room', 'RoomController@getRoomByFlat')->name('crm.rooms.get-room');
        Route::post('/get-avail-room', 'RoomController@getAvailableRoomByFlat')->name('crm.rooms.get-avail-room');
        Route::delete('/{id}/delete', 'RoomController@delete')->name('crm.rooms.delete');
    });

    Route::group(['prefix' => 'admin/crm/seats'], function () {
        Route::get('/', 'SeatController@index')->name('crm.seats.index');
        Route::get('/create', 'SeatController@create')->name('crm.seats.create');
        Route::post('/store', 'SeatController@store')->name('crm.seats.store');
        Route::get('/{id}/edit', 'SeatController@edit')->name('crm.seats.edit');
        Route::post('/get-seat', 'SeatController@getSeatByRoom')->name('crm.seats.get-seat');
        Route::post('/get-avail-seat', 'SeatController@getAvaiableSeatByRoom')->name('crm.seats.get-avail-seat');
        Route::post('/{id}/update', 'SeatController@update')->name('crm.seats.update');
        Route::delete('/{id}/delete', 'SeatController@delete')->name('crm.seats.delete');
    });

    Route::group(['prefix' => 'admin/crm/seat-prices'], function () {
        Route::get('/', 'SeatPriceController@index')->name('crm.seat-prices.index');
        Route::get('/create', 'SeatPriceController@create')->name('crm.seat-prices.create');
        Route::post('/store', 'SeatPriceController@store')->name('crm.seat-prices.store');
        Route::get('/{id}/edit', 'SeatPriceController@edit')->name('crm.seat-prices.edit');
        Route::post('/get-price', 'SeatPriceController@getPriceBySeat')->name('crm.seat-prices.get-price');
        Route::post('/{id}/update', 'SeatPriceController@update')->name('crm.seat-prices.update');
        Route::post('/deactive', 'SeatPriceController@deactive')->name('crm.seat-prices.deactive');
        Route::delete('/{id}/delete', 'SeatPriceController@delete')->name('crm.seat-prices.delete');
    });

    Route::group(['prefix' => 'admin/crm/customers'], function () {
        Route::get('/', 'CustomerController@index')->name('crm.customers.index');
        Route::get('/create', 'CustomerController@create')->name('crm.customers.create');
        Route::post('/store', 'CustomerController@store')->name('crm.customers.store');
        Route::post('/get-by-name', 'CustomerController@getCustomerByName')->name('customer.name.autocomplete');
        Route::post('/get-by-phone', 'CustomerController@getCustomerByPhone')->name('customer.phone.autocomplete');
        Route::get('/{id}/edit', 'CustomerController@edit')->name('crm.customers.edit');
        Route::post('/{id}/update', 'CustomerController@update')->name('crm.customers.update');
        Route::delete('/{id}/delete', 'CustomerController@delete')->name('crm.customers.delete');
    });

    Route::group(['prefix' => 'admin/crm/seat-booking'], function () {
        Route::get('/', 'SeatBookingController@index')->name('crm.seat-booking.index');
        Route::get('/create', 'SeatBookingController@create')->name('crm.seat-booking.create');
        Route::post('/store', 'SeatBookingController@store')->name('crm.seat-booking.store');
        Route::get('/{id}/edit', 'SeatBookingController@edit')->name('crm.seat-booking.edit');
        Route::get('/{id}/voucher', 'SeatBookingController@voucher')->name('crm.seat-booking.voucher');
        Route::post('/{id}/update', 'SeatBookingController@update')->name('crm.seat-booking.update');
        Route::delete('/{id}/delete', 'SeatBookingController@delete')->name('crm.seat-booking.delete');
    });
});
