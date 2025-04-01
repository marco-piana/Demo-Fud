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

use Modules\Tablereservations\Http\Controllers\APIController;
use Modules\Tablereservations\Http\Controllers\Main;

Route::prefix('tablereservations')->group(function() {
    Route::get('/', 'TablereservationsController@index');
});

Route::group([
    'middleware' =>[ 'web','impersonate','auth'],
    'namespace' => 'Modules\Tablereservations\Http\Controllers'
], function () {
    Route::prefix('tablereservations')->group(function() {
        // CRUD for table reservations
        Route::resource('reservation', Main::class, ['names' => 'tablereservations']);

        // Panel for table reservations
        Route::get('panel', 'PanelController@index')->name('tablereservations.panel');
    });
});

Route::group([
    'middleware' =>[ 'web'],
    'namespace' => 'Modules\Tablereservations\Http\Controllers'
], function () {
    Route::prefix('api')->group(function() {
        // Create reservation
        Route::post('createreservation',    'APIController@createReservation');
        
        // Update reservation
        Route::post('updatereservation',    'APIController@updateReservation');

  
        // Get reservations with optional parameters
        Route::get('getreservations/{area?}/{date?}', 'APIController@getReservations');

        // Get available tables for a specific date, time and period
        Route::post('getavailabletables', 'APIController@getAvailableTables');

    });
});
