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

Route::GET('/', 'GuestController@landing')->name('landing');


Route::group(['middleware' => 'auth'], function(){
    Route::GET('/dashboard', 'HomeController@index')->name('home');

    Route::GET('/history', 'HomeController@getUserSponsorHistory')->name('history');

    Route::GET('/success', 'HomeController@showSuccessPage');

    Route::group(['prefix' => 'sponsorships'], function(){
        Route::GET('/{id}', 'HomeController@showSingleSponsorship');
    });

    Route::group(['prefix' => 'sponsors'], function(){
        Route::POST('/create', 'HomeController@createSponsor');

        Route::GET('/{id}', 'HomeController@openSponsorPage');
    });
});

Auth::routes();
