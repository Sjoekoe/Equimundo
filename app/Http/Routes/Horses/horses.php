<?php

get('horses/index/{user}', ['as' => 'horses.index', 'uses' => 'HorseController@index', 'middleware' => 'auth']);
get('horses/create', ['as' => 'horses.create', 'uses' => 'HorseController@create', 'middleware' => 'auth']);
post('horses/create', ['as' => 'horses.store', 'uses' => 'HorseController@store']);
get('horses/edit/{horse_slug}', ['as' => 'horses.edit', 'uses' => 'HorseController@edit', 'middleware' => 'auth']);
put('horses/edit/{horse_slug}', ['as' => 'horses.update', 'uses' => 'HorseController@update']);
get('horses/{horse_slug}', ['as' => 'horses.show', 'uses' => 'HorseController@show', 'middleware' => 'auth']);
get('horses/{horse_slug}/delete', ['as' => 'horses.delete', 'uses' => 'HorseController@delete', 'middleware' => 'auth']);
