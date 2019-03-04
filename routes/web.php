<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'HomeController@index')->name("main");
Route::get('/minor', 'HomeController@minor')->name("minor");


Route::middleware('auth')->group(function (){
    Route::prefix('clubes')->namespace('Clubs')->group(function (){
        Route::get('/list', 'ClubesListController@index')->name('clubes_list');

        Route::get('/create', 'ClubesFormController@index')->name('clubes_create');
    });


    Route::prefix('perfil')->namespace('Profile')->group(function (){
        Route::get('/', 'VerPerfilController@index')->name('profile');
    });
});


Auth::routes();