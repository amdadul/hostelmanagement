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
});
