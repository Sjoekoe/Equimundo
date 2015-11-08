<?php

get('horses/{horseSlug}/followers', ['as' => 'follows.index', 'uses' => 'FollowsController@index', 'middleware' => 'auth']);
post('follows', ['as' => 'follows.store', 'uses' => 'FollowsController@store', 'middleware' => 'auth'])->before('csrf');
delete('follows/{id}', ['as' => 'follows.destroy', 'uses' => 'FollowsController@destroy', 'middleware' => 'auth']);
