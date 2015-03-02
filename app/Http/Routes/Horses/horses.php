<?php

Route::get('horses/index', ['as' => 'horses.index', 'uses' => 'HorseController@index', 'middleware' => 'auth']);
Route::get('horses/create', ['as' => 'horses.create', 'uses' => 'HorseController@create', 'middelware' => 'auth']);
Route::post('horses/create', ['as' => 'horses.create', 'uses' => 'HorseController@store'])->before('csrf');
Route::get('horses/{slug}', ['as' => 'horses.show', 'uses' => 'HorseController@show']);