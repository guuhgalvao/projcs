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

Route::prefix('home')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::prefix('management')->group(function () {
        Route::prefix('clients')->group(function () {
            Route::get('/', 'Management\ClientsController@index')->name('clients');
            Route::post('/', 'Management\ClientsController@actions');
        });

        Route::prefix('providers')->group(function () {
            Route::get('/', 'Management\ProvidersController@index')->name('providers');
        });
    });
});
