<?php

get('horses/{horse_slug}/palmares', ['as' => 'palmares.index', 'uses' => 'PalmaresController@index']);
get('horses/{horse_slug}/palmares/create', ['as' => 'palmares.create', 'uses' => 'PalmaresController@create', 'middleware' => 'auth']);
post('horses/{horse_slug}/palmares/create', ['as' => 'palmares.store', 'uses' => 'PalmaresController@store', 'middleware' => 'auth']);
get('palmares/{palmares}/edit', ['as' => 'palmares.edit', 'uses' => 'PalmaresCOntroller@edit', 'middleware' => 'auth']);
put('palmares/{palmares}/edit', ['as' => 'palmares.update', 'uses' => 'PalmaresController@update', 'middleware' => 'auth']);
get('palmares/{palmares}/delete', ['as' => 'palmares.delete', 'uses' => 'PalmaresController@delete', 'middleware' => 'auth']);
