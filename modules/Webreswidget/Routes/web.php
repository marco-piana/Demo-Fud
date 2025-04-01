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


Route::group([
    'middleware' =>[ 'web'],
    'namespace' => 'Modules\Webreswidget\Http\Controllers'
], function () {
    Route::get('/popup/webreswidget', 'Main@index')->name('webreswidget.popup');
    Route::post('/api/submit_reservation', 'Main@makereservation')->name('webreswidget.makereservation');
    Route::group(['middleware' => ['auth','XssSanitizer']], function () {
        Route::get('/webreswidget/widget/edit', 'Main@edit')->name('webreswidget.edit');
        Route::post('/webreswidget/widget/save', 'Main@store')->name('webreswidget.store');
    });
    });
    
