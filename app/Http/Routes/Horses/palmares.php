<?php

Route::get('horses/{slug}/palmares', ['as' => 'palmares.index', 'uses' => 'PalmaresController@index', 'middleware' => 'auth']);
Route::get('horses/{slug}/palmares/create', ['as' => 'palmares.create', 'uses' => 'PalmaresController@create', 'middleware' => 'auth']);
Route::post('horses/{slug}/palmares/create', ['as' => 'palmares.store', 'uses' => 'PalmaresController@store', 'middleware' => 'auth'])->before('csrf');
Route::get('palmares/{palmares}/edit', ['as' => 'palmares.edit', 'uses' => 'PalmaresCOntroller@edit', 'middleware' => 'auth']);
Route::post('palmares/{palmares}/edit', ['as' => 'palmares.update', 'uses' => 'PalmaresController@update', 'middleware' => 'auth'])->before('csrf');
Route::get('palmares/{palmares}/delete', ['as' => 'palmares.delete', 'uses' => 'PalmaresController@delete', 'middleware' => 'auth']);
