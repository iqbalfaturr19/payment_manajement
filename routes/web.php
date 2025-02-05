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
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    //Bonus
    Route::get('/bonuses', 'BonusesController@index')->name('bonuses.index');
    Route::get('/bonuses/create', 'BonusesController@create')->name('bonuses.create');
    Route::post('/bonuses/store', 'BonusesController@store')->name('bonuses.store');
    Route::get('/bonuses/{id}/edit', 'BonusesController@edit')->name('bonuses.edit');
    Route::get('/bonuses/{id}/detail', 'BonusesController@show')->name('bonuses.detail');
    Route::put('/bonuses/{id}', 'BonusesController@update')->name('bonuses.update');
    Route::delete('/bonuses/{id}', 'BonusesController@destroy')->name('bonuses.destroy');
});