<?php

Route::prefix('admin')->group(function () {
    Route::view('/', 'admin.login')->middleware('admin');
    Route::view('login', 'admin.login')->middleware('admin');
    Route::post('login', 'Auth\LoginController@login');

    Route::middleware('admin.auth')->group(function () {
        Route::get('dashboard', 'DashboardController@index');

        Route::view('bookings', 'admin.bookings');
        Route::prefix('bookings')->group(function () {
            Route::get('all', 'BookingController@all');
            Route::get('search/{name}', 'BookingController@search');
            Route::post('create', 'BookingController@create');
            Route::post('update', 'BookingController@update');
            Route::get('delete/{id}', 'BookingController@delete');

            Route::post('complete', 'BookingController@completeBooking');
        });

        Route::view('services', 'admin.services');
        Route::prefix('services')->group(function () {
            Route::get('all', 'ServiceController@all');
            Route::post('create', 'ServiceController@create');
            Route::post('update', 'ServiceController@update');
            Route::get('delete/{id}', 'ServiceController@delete');

            Route::get('get-services', 'ServiceController@getServices');
        });

        Route::view('customers', 'admin.customers');
        Route::prefix('customers')->group(function () {
            Route::get('all', 'CustomerController@all');
            Route::post('create', 'CustomerController@create');
            Route::post('update', 'CustomerController@update');
            Route::get('delete/{id}', 'CustomerController@delete');

            Route::post('async-customers', 'CustomerController@getAsyncCustomers');
        });

        Route::view('admins', 'admin.admins');
        Route::prefix('admins')->group(function () {
            Route::get('all', 'AdminController@all');
            Route::post('create', 'AdminController@create');
            Route::post('update', 'AdminController@update');
            Route::get('delete/{id}', 'AdminController@delete');
        });
    });

    Route::get('/logout', 'Auth\LoginController@logout');
});
