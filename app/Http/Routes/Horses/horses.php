<?php

Route::get('horses/index/{userId}', ['as' => 'horses.index', 'uses' => 'HorseController@index', 'middleware' => 'auth']);
Route::get('horses/create', ['as' => 'horses.create', 'uses' => 'HorseController@create', 'middleware' => 'auth']);
Route::post('horses/create', ['as' => 'horses.create', 'uses' => 'HorseController@store'])->before('csrf');
Route::get('horses/edit/{horseId}', ['as' => 'horses.edit', 'uses' => 'HorseController@edit', 'middleware' => 'auth']);
Route::put('horses/edit/{horseId}', ['as' => 'horses.update', 'uses' => 'HorseController@update'])->before('csrf');
Route::get('horses/{slug}', ['as' => 'horses.show', 'uses' => 'HorseController@show', 'middleware' => 'auth']);
