<?php

Route::get('horses/{horse_slug}/palmares', ['as' => 'palmares.index', 'uses' => 'PalmaresController@index']);
Route::get('horses/{horse_slug}/palmares/create', ['as' => 'palmares.create', 'uses' => 'PalmaresController@create', 'middleware' => 'auth']);
Route::post('horses/{horse_slug}/palmares/create', ['as' => 'palmares.store', 'uses' => 'PalmaresController@store', 'middleware' => 'auth']);
Route::get('palmares/{palmares}/edit', ['as' => 'palmares.edit', 'uses' => 'PalmaresCOntroller@edit', 'middleware' => 'auth']);
Route::put('palmares/{palmares}/edit', ['as' => 'palmares.update', 'uses' => 'PalmaresController@update', 'middleware' => 'auth']);
Route::get('palmares/{palmares}/delete', ['as' => 'palmares.delete', 'uses' => 'PalmaresController@delete', 'middleware' => 'auth']);
