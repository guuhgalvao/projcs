<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::group(['prefix' => 'home',  'middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::post('/', 'HomeController@actions');

    Route::prefix('services')->group(function () {
        Route::get('/', 'Management\ServicesController@index')->name('services');
        Route::post('/', 'Management\ServicesController@actions');
        Route::get('/start', 'Management\ServicesController@start')->name('start_service');
        Route::get('/finish/{service_id}', 'Management\ServicesController@finish');
        Route::get('/pdf', 'Management\ServicesController@pdf');
    });

    Route::prefix('management')->group(function () {
        Route::prefix('clients')->group(function () {
            Route::get('/', 'Management\ClientsController@index')->name('clients');
            Route::post('/', 'Management\ClientsController@actions');
        });

        Route::prefix('payment_methods')->group(function () {
            Route::get('/', 'Management\PaymentMethodsController@index')->name('payment_methods');
            Route::post('/', 'Management\PaymentMethodsController@actions');
        });

        Route::prefix('providers')->group(function () {
            Route::get('/', 'Management\ProvidersController@index')->name('providers');
            Route::post('/', 'Management\ProvidersController@actions');
        });

        Route::prefix('service_types')->group(function () {
            Route::get('/', 'Management\ServiceTypesController@index')->name('service_types');
            Route::post('/', 'Management\ServiceTypesController@actions');
        });

        Route::prefix('values')->group(function () {
            Route::get('/', 'Management\ServiceTypesValuesController@index')->name('values');
            Route::post('/', 'Management\ServiceTypesValuesController@actions');
        });

        Route::prefix('vehicles')->group(function () {
            Route::get('/', 'Management\VehiclesController@index')->name('vehicles');
            Route::post('/', 'Management\VehiclesController@actions');
        });

        Route::prefix('users')->group(function () {
            Route::get('/', 'Management\UsersController@index')->name('users');
            Route::post('/', 'Management\UsersController@actions');
        });
    });
});
