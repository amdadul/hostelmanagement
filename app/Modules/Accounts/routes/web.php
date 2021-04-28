<?php

Route::group(['middleware' => ['auth:web']], function () {

    Route::get('accounts', 'AccountsController@welcome');

    Route::group(['prefix' => 'admin/accounts/expense-types'], function () {
        Route::get('/', 'ExpenseTypeController@index')->name('accounts.expense-types.index');
        Route::get('/create', 'ExpenseTypeController@create')->name('accounts.expense-types.create');
        Route::post('/store', 'ExpenseTypeController@store')->name('accounts.expense-types.store');
        Route::get('/{id}/edit', 'ExpenseTypeController@edit')->name('accounts.expense-types.edit');
        Route::post('/{id}/update', 'ExpenseTypeController@update')->name('accounts.expense-types.update');
        Route::delete('/{id}/delete', 'ExpenseTypeController@delete')->name('accounts.expense-types.delete');
    });

    Route::group(['prefix' => 'admin/accounts/asset-types'], function () {
        Route::get('/', 'AssetsTypeController@index')->name('accounts.asset-types.index');
        Route::get('/create', 'AssetsTypeController@create')->name('accounts.asset-types.create');
        Route::post('/store', 'AssetsTypeController@store')->name('accounts.asset-types.store');
        Route::get('/{id}/edit', 'AssetsTypeController@edit')->name('accounts.asset-types.edit');
        Route::post('/{id}/update', 'AssetsTypeController@update')->name('accounts.asset-types.update');
        Route::delete('/{id}/delete', 'AssetsTypeController@delete')->name('accounts.asset-types.delete');
    });

    Route::group(['prefix' => 'admin/accounts/assets'], function () {
        Route::get('/', 'AssetsController@index')->name('accounts.assets.index');
        Route::get('/create', 'AssetsController@create')->name('accounts.assets.create');
        Route::post('/store', 'AssetsController@store')->name('accounts.assets.store');
        Route::get('/{id}/edit', 'AssetsController@edit')->name('accounts.assets.edit');
        Route::post('/{id}/update', 'AssetsController@update')->name('accounts.assets.update');
        Route::delete('/{id}/delete', 'AssetsController@delete')->name('accounts.assets.delete');
    });

    Route::group(['prefix' => 'admin/accounts/money-receipt'], function () {
        Route::get('/', 'MoneyReceiptController@index')->name('accounts.money-receipt.index');
        Route::get('/create', 'MoneyReceiptController@create')->name('accounts.money-receipt.create');
        Route::post('/store', 'MoneyReceiptController@store')->name('accounts.money-receipt.store');
        Route::get('/{id}/edit', 'MoneyReceiptController@edit')->name('accounts.money-receipt.edit');
        Route::get('/{id}/voucher', 'MoneyReceiptController@voucher')->name('accounts.money-receipt.voucher');
        Route::post('/{id}/update', 'MoneyReceiptController@update')->name('accounts.money-receipt.update');
        Route::delete('/{id}/delete', 'MoneyReceiptController@delete')->name('accounts.money-receipt.delete');
    });
});
