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

Route::prefix('cards')->group(function() {
    Route::get('/', 'CardsController@index');
});

Route::group([
    'middleware' =>[ 'web','impersonate'],
], function () {
    Route::get('rewards/{alias}', 'App\Http\Controllers\FrontEndController@loyalty')->name('loyalty.landing');
});


Route::group([
    'middleware' =>[ 'web','impersonate'],
    'namespace' => 'Modules\Cards\Http\Controllers'
], function () {
    Route::prefix('loyalty')->group(function() { 

        Route::post('calculate', 'Main@calculatePoints')->name('loyalty.calculate');

        Route::get('give', 'Main@showPointGiveForm')->name('loyalty.give');
        Route::post('give', 'Main@givePoints')->name('loyalty.give');
        Route::get('remove', 'Main@showPointRemoveForm')->name('loyalty.remove');
        Route::post('remove', 'Main@removePoints')->name('loyalty.remove');
        Route::get('exchange/{reward}', 'Main@exchangePoints')->name('loyalty.exchange');

        //Cards
        Route::get('cards', 'CardsController@index')->name('loyalty.cards.index')->middleware('isOwnerOnPro');
        Route::get('cards/{card}/edit', 'CardsController@edit')->name('loyalty.cards.edit');
        Route::get('cards/create', 'CardsController@create')->name('loyalty.cards.create');
        Route::post('cards', 'CardsController@store')->name('loyalty.cards.store');
        Route::put('cards/{card}', 'CardsController@update')->name('loyalty.cards.update');
        Route::get('cards/del/{card}', 'CardsController@destroy')->name('loyalty.cards.delete');

        //CARD MOVEMENTS
        Route::get('movements/{card}', 'MovmentsController@index')->name('loyalty.movments.index')->middleware('isOwnerOnPro');
        Route::get('movements', 'MovmentsController@peruser')->name('loyalty.movments.peruser')->middleware('isOwnerOnPro');
       

        // Points Distribution
        Route::get('loyaltypoints', 'PointsDistributionController@index')->name('loyaltypoints.index')->middleware('isOwnerOnPro');
        Route::get('loyaltypoints/{category}/edit', 'PointsDistributionController@edit')->name('loyaltypoints.edit');
        Route::get('loyaltypoints/create', 'PointsDistributionController@create')->name('loyaltypoints.create');
        Route::post('loyaltypoints', 'PointsDistributionController@store')->name('loyaltypoints.store');
        Route::put('loyaltypoints/{category}', 'PointsDistributionController@update')->name('loyaltypoints.update');
        Route::get('loyaltypoints/del/{category}', 'PointsDistributionController@destroy')->name('loyaltypoints.delete');


        //Awards
        Route::get('loyaltyawards', 'RewardsController@index')->name('loyaltyawards.index')->middleware('isOwnerOnPro');
        Route::get('loyaltyawards/create', 'RewardsController@create')->name('loyaltyawards.create')->middleware('isOwnerOnPro');
        Route::post('loyaltyawards', 'RewardsController@store')->name('loyaltyawards.store')->middleware('isOwnerOnPro');
        Route::get('loyaltyawards/edit/{post}', 'RewardsController@edit')->name('loyaltyawards.edit')->middleware('isOwnerOnPro');
        Route::get('loyaltyawards/del/{post}', 'RewardsController@destroy')->name('loyaltyawards.delete');
        Route::put('loyaltyawards/{post}', 'RewardsController@update')->name('loyaltyawards.update');
        Route::get('awards', 'RewardsController@peruser')->name('loyaltyawards.peruser')->middleware('isOwnerOnPro');
    
        //FAQ
        Route::get('loyaltyfaq', 'FAQController@index')->name('loyaltyfaq.index')->middleware('isOwnerOnPro');
        Route::get('loyaltyfaq/create', 'FAQController@create')->name('loyaltyfaq.create')->middleware('isOwnerOnPro');
        Route::post('loyaltyfaq', 'FAQController@store')->name('loyaltyfaq.store')->middleware('isOwnerOnPro');
        Route::get('loyaltyfaq/edit/{post}', 'FAQController@edit')->name('loyaltyfaq.edit')->middleware('isOwnerOnPro');
        Route::get('loyaltyfaq/del/{post}', 'FAQController@destroy')->name('loyaltyfaq.delete');
        Route::put('loyaltyfaq/{post}', 'FAQController@update')->name('loyaltyfaq.update');

        //Slides
        Route::get('loyaltyslides', 'SlidesController@index')->name('loyaltyslides.index')->middleware('isOwnerOnPro');
        Route::get('loyaltyslides/create', 'SlidesController@create')->name('loyaltyslides.create')->middleware('isOwnerOnPro');
        Route::post('loyaltyslides', 'SlidesController@store')->name('loyaltyslides.store')->middleware('isOwnerOnPro');
        Route::get('loyaltyslides/edit/{post}', 'SlidesController@edit')->name('loyaltyslides.edit')->middleware('isOwnerOnPro');
        Route::get('loyaltyslides/del/{post}', 'SlidesController@destroy')->name('loyaltyslides.delete');
        Route::put('loyaltyslides/{post}', 'SlidesController@update')->name('loyaltyslides.update');

        //Pages
        Route::get('loyaltypages', 'PagesController@index')->name('loyaltypages.index')->middleware('isOwnerOnPro');
        Route::get('loyaltypages/create', 'PagesController@create')->name('loyaltypages.create')->middleware('isOwnerOnPro');
        Route::post('loyaltypages', 'PagesController@store')->name('loyaltypages.store')->middleware('isOwnerOnPro');
        Route::get('loyaltypages/edit/{post}', 'PagesController@edit')->name('loyaltypages.edit')->middleware('isOwnerOnPro');
        Route::get('loyaltypages/del/{post}', 'PagesController@destroy')->name('loyaltypages.delete');
        Route::put('loyaltypages/{post}', 'PagesController@update')->name('loyaltypages.update');



    });
});
