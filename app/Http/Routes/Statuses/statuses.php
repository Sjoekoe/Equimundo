<?php

post('statuses/create', ['as' => 'statuses.store', 'uses' => 'StatusController@store', 'middleware' => 'auth']);
get('status/{status}/show', ['as' => 'statuses.show', 'uses' => 'StatusController@show']);
get('status/{status}/edit', ['as' => 'statuses.edit', 'uses' => 'StatusController@edit', 'middleware' => 'auth']);
put('status/{status}/edit', ['as' => 'statuses.update', 'uses' => 'StatusController@update', 'middleware' => 'auth']);
get('status/{status}/delete', ['as' => 'statuses.delete', 'uses' => 'StatusController@delete', 'middleware' => 'auth']);
