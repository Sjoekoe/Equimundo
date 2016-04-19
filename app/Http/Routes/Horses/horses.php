<?php

Route::get('horses/index/{user}', ['as' => 'horses.index', 'uses' => 'HorseController@index', 'middleware' => 'auth']);
Route::get('horses/create', ['as' => 'horses.create', 'uses' => 'HorseController@create', 'middleware' => 'auth']);
Route::post('horses/create', ['as' => 'horses.store', 'uses' => 'HorseController@store']);
Route::get('horses/edit/{horse_slug}', ['as' => 'horses.edit', 'uses' => 'HorseController@edit', 'middleware' => 'auth']);
Route::put('horses/edit/{horse_slug}', ['as' => 'horses.update', 'uses' => 'HorseController@update']);
Route::get('horses/{horse_slug}', ['as' => 'horses.show', 'uses' => 'HorseController@show']);
Route::get('api/horses/data/{horse}', ['as' => 'api.horses.data', 'uses' => 'HorseController@data', 'middleware' => 'auth']);
